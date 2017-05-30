<?
use \Bitrix\Main\Loader as Loader;
use \Bitrix\Main\Entity\Query as Query;
use \Bitrix\Iblock\ElementTable as ElementTable;
use \Bitrix\Iblock\SectionTable as SectionTable;

class SimpleCatalogSections extends CBitrixComponent
{
    protected $select;
    protected $filter;
    protected $order;
    protected $limit;


    /**
     * Перегружаем конструктор компонента
     * @param null $component
     */
    public function __construct($component = null)
    {
        parent::__construct($component);

        /**
         * Инициализируем запрос на выборку элементов дефолтными значениями
         */
        $this->select = array();
        $this->filter = array();
        $this->order = array('ID' => 'DESC');
        $this->limit = 10;

    }


    /**
     * Исполнение компонента.
     */
    public function executeComponent()
    {
        // Проверяем существует-ли секция
        if(!$this->isSectionExist())
        {
            $this->show404();
        }

        //Подготовка запроса
        $this->prepareQuery();

        //Исполняем запрос
        $cdbr = $this->qExecute()->exec();

        // Извлекаем из CDBResult массив и создаем URL для элементов
        $this->extractCDBR($cdbr);

        // Получаем свойства элементов
        $this->getElementsProperty();

        // Обрабатываем изображения
        $this->resizeImages();

        // Подключаем шаблон
        $this->IncludeComponentTemplate();
    }

    /**
     * Проверка существования секции
     * @return Query|bool
     */
    protected function isSectionExist()
    {
        /**
         * Компонент вызывается либо на индексных страницах с содержимым различных разделов,
         * либо на страницах секции с объявленной переменной SECTION_CODE, таким образом надо смотреть
         * именно на наличие секции указанной в переменной.
         */

        if($this->arParams['SECTION_CODE'] != NULL)
        {
            Loader::includeModule('iblock');

            $exeQuery = new Query(SectionTable::getEntity());

            $dbSection = $exeQuery->setSelect(array("ID", "NAME"))
                ->setFilter(array("CODE" => $this->arParams['SECTION_CODE']))
                ->exec();

            if($dbSection->getSelectedRowsCount() > 0)
            {
                /**
                 * Получим некоторые данные о секции
                 */
                $this->arResult['SECTION'] = $dbSection->fetch();
                return true;
            }
            else
                {
                return false;
            }
        }
        else
        {
            return true;
        }
    }

    /**
     * Вывод 404 страницы
     */
    protected function show404()
    {
        global $APPLICATION;

        \CHTTP::setStatus("404 Not Found");

        $APPLICATION->RestartWorkarea();

        if ($this->arParams['PAGE_404'] == NULL)
        {
            $linkPage404 = "/404.php";
        }
        else
        {
            $linkPage404 = $this->arParams['PAGE_404'];
        }

        require(\Bitrix\Main\Application::getDocumentRoot().$linkPage404);

        exit();
    }

    /**
     * Добавляем в массив выбираемых полей массив с новыми
     * @param array $matchSelect
     * @return bool
     */
    protected function addToSelect(array $matchSelect)
    {
        $this->select = array_merge($this->filter, $matchSelect);
        return true;
    }


    /**
     * Добавляем в массив фильтрации записей, массив с новыми условиями
     * @param array $matchFilter
     * @return bool
     */
    protected function addToFilter(array $matchFilter)
    {
        $this->filter = array_merge($this->filter, $matchFilter);
        return true;
    }


    /**
     * Устанавливаем поле и направление сортировки
     * @param $rule
     * @return bool
     */
    protected function setToOrder($rule)
    {
        $this->order = array($rule);
        return true;
    }


    /**
     * Устанавливаем ограничение выборки
     * @param $intLimit
     * @return bool
     */
    protected function setToLimit($intLimit)
    {
        $this->limit = $intLimit;
        return true;
    }

    /**
     * Подготавливаем запрос на получение элементов секции
     */
    protected function prepareQuery()
    {
        // Формируем параметры запроса
        $this->addToSelect($this->arParams['FIELD_TO_SECTION']);
        $this->addToFilter($this->arParams['FILTER']);
        $this->setToOrder($this->arParams['ORDER']);
        $this->setToLimit($this->arParams['LIMIT']);


        // Если код секции указан добавляем фильтр по ней
        if($this->arParams['SECTION_CODE'] != NULL)
        {
            $this->addToFilter(array('IBLOCK_ELEMENT_IBLOCK_SECTION_CODE' => $this->arParams['SECTION_CODE']));
        }
    }

    /**
     * Формируем и исполняем запрос на выборку элементов
     * @return Query
     */
    protected function qExecute()
    {
        Loader::includeModule('iblock');

        $exeQuery = new Query(ElementTable::getEntity());

        return $exeQuery
            ->setSelect($this->select)
            ->setFilter($this->filter)
            ->setOrder($this->order)
            ->setLimit($this->limit);
    }


    /**
     * Извлечение массива из CDBResult и создание путей
     * @param $cdbr
     */
    protected function extractCDBR($cdbr)
    {
        while ($arElem = $cdbr->fetch())
        {
            $arElem['SEF_FOLDER'] = $this->getSefFolder();
            $arElem['SECTION_URL'] = $this->getSectionPageUrl();
            $arElem['DETAIL_PAGE_URL'] = $this->getDetailPageUrl($arElem);
            $this->arResult['ITEMS'][] = $arElem;


        }

    }


    /**
     * Получаем свойства элемента
     */
    protected function getElementsProperty()
    {
        for($i = 0; $i < count($this->arResult['ITEMS']); $i++ )
        {
            $dbProp = \CIBlockElement::getProperty($this->arResult['ITEMS'][$i]['IBLOCK_ID'],
                $this->arResult['ITEMS'][$i]['ID']);

            while($arProperty = $dbProp->Fetch())
            {
                $this->arResult['ITEMS'][$i]['PROPERTY'][$arProperty['CODE']] = $arProperty;
            }

        }
    }


    /**
     * Подготавливаем изображения для вывода в категории (масштабируем и кидаем в кэш)
     */
    protected function resizeImages()
    {
        /**
         * Для сохранения ресурсов обращаемся напрямую к защищенной переменной $arResult
         */
        for($i = 0; $i < count($this->arResult['ITEMS']); $i++ )
        {
            $this->arResult['ITEMS'][$i]['PREVIEW_PICTURE'] = CFile::ResizeImageGet(
                $this->arResult['ITEMS'][$i]['PREVIEW_PICTURE'], array(width => "300", height=> "175"));
        }
    }

    /**
     * Получаем SEF-фолдер компонента
     * @return string
     */
    protected  function getSefFolder()
    {
        return $this->arParams['SEF_FOLDER'];
    }

    /**
     * Получаем URL секции
     * @param string $urlTempl
     * @return string
     */
    protected function getSectionPageUrl($urlTempl = 'section')
    {

        $urlTemplates = $this->arParams['URL_TEMPLATES'];
        $urlVariables = $this->arParams['URL_VARIABLES'];

        foreach ($urlVariables as $urlCode => $urlValue)
        {
            $urlRow = str_replace('#'.$urlCode.'#', $urlValue, $urlTemplates[$urlTempl]);

        }

        return $this->getSefFolder().$urlRow;
    }

    /**
     * Получаем путь к странице детального просмотра элемента
     * @param $element
     * @return string
     */
    protected function getDetailPageUrl($arElement)
    {
        $sectionUrl = $this->getSectionPageUrl('element');
        /**
         * Если страница выводит элементы из нескольких секций то параметр url SECTION_CODE будет отсутствовать.
         * Исправляем это принудительным назначением секции из данных элемента
         * и вновь вызываем функцию получения пути к секции
         */

         if($sectionUrl == $this->getSefFolder())
        {
            $this->arParams['URL_VARIABLES'] = array(
                    $this->arParams['SEF_VARIABLES']['section'] => $arElement['IBLOCK_ELEMENT_IBLOCK_SECTION_CODE']);
            $sectionUrl = $this->getSectionPageUrl('element');

            // Обнуляем массив с переменными url
            $this->arParams['URL_VARIABLES'] = array();
        }

            $urlRow = preg_replace('@\#[^/]+\#@siu', $arElement['CODE'], $sectionUrl);


        return $urlRow;
    }


}
?>