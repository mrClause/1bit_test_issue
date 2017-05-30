<?
use \Bitrix\Main\Loader as Loader;
use \Bitrix\Main\Entity\Query as Query;
use \Bitrix\Iblock\ElementTable as ElementTable;
use \Bitrix\Iblock\PropertyTable as PropertyTable;

class SimpleCatalogElement extends CBitrixComponent
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
        $this->limit = 1;

    }

    /**
     * Исполнение компонента.
     */
    public function executeComponent()
    {

        // Исполняем запрос на получение элемента
        $dbQuery = $this->qExecute()->exec();


        // Проверяем существует-ли элемент
        if($dbQuery->getSelectedRowsCount() == 0)
        {
            $this->show404();
        }

        // Распаковываем CDBResult в массив
        $this->arResult = $dbQuery->fetch();

        // Получаем свойства элементов
        $this->getElementsProperty();

        // Обрабатываем изображения
        $this->resizeImages();

        // Подключаем шаблон
        $this->IncludeComponentTemplate();
    }

    /**
     * Добавляем в массив выбираемых полей массив с новыми (дублирующиеся ключи перезапишутся)
     * @param array $matchSelect
     * @return bool
     */
    protected function addToSelect(array $matchSelect)
    {
        $this->select = array_merge($this->filter, $matchSelect);
        return true;
    }

    /**
     * Добавляем в массив фильтрации записей, массив с новыми условиями (дублирующиеся ключи перезапишутся)
     * @param array $matchFilter
     * @return bool
     */
    protected function addToFilter(array $matchFilter)
    {
        $this->filter = array_merge($this->filter, $matchFilter);
        return true;
    }

    /**
     * Исполняем запрос на получение элемента
     * @return Query
     */
    protected function qExecute()
    {
        Loader::includeModule('iblock');

        // Формируем параметры запроса на получение элемента
        $this->addToSelect($this->arParams['FIELD_TO_DETAIL']);

        // Если код секции указан добавляем фильтр по ней
        if($this->arParams['ELEMENT_CODE'] != NULL)
        {
            $this->addToFilter(array('CODE' => $this->arParams['ELEMENT_CODE']));
        }


        $exeQuery = new Query(ElementTable::getEntity());

        return $exeQuery
            ->setSelect($this->select)
            ->setFilter($this->filter);
    }

    /**
     * Получаем свойства элемента
     */
    protected function getElementsProperty()
    {
        $dbProp = \CIBlockElement::getProperty($this->arResult['IBLOCK_ID'], $this->arResult['ID']);

        while($arProperty = $dbProp->Fetch())
        {
            $this->arResult['PROPERTY'][$arProperty['CODE']] = $arProperty;
        }
    }

    /**
     * Подготавливаем изображения для вывода в категории (масштабируем и кидаем в кэш)
     */
    protected function resizeImages()
    {
        $link_url = $this->getDetailPicturePath($this->arResult['DETAIL_PICTURE']);

        /**
         * Для сохранения ресурсов обращаемся напрямую к защищенной переменной $arResult
         */
            $this->arResult['DETAIL_PICTURE'] = CFile::ResizeImageGet(
                $this->arResult['DETAIL_PICTURE'], array(width => "400", height=> "250"));

            $this->arResult['DETAIL_PICTURE']['FULL_LINK'] = $link_url;
    }

    /**
     * Получаем путь к несжатому файлу
     * @param $id
     */
    protected function getDetailPicturePath($id)
    {
        return CFile::GetPath($id);
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


}
?>
