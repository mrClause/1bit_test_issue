<?
use \Bitrix\Main\Loader as Loader;
use \Bitrix\Main\Entity\Query as Query;
use \Bitrix\Iblock\ElementTable as ElementTable;


class SimpleRelatedProducts extends CBitrixComponent
{

    protected $arPropValues;
    protected $intElementId;

    public function __construct($component = null)
    {
        parent::__construct($component);
    }

    /**
     * Исполнение компонента.
     */
    public function executeComponent()
    {
        /**
         * Устанавливаем заголовок для компонента
         */
        $this->arResult['LABEL'] = $this->arParams['COMPONENT_LABEL'];

        /**
         * Получаем и записываем в защищенную переменную класса идентификатор элемента
         */
       $this->setIntElementId($this->getProductID()['ID']);

        /**
         * Получаем массив идентификаторов элементов привязанных по свойству
         */
       $this->setPropListValues();

        /**
         * Получаем массив данных о элементах
         */
        $this->arResult['ITEMS'] = $this->getProductsArray();

        /**
         * Получаем детальные пути элементов
         */
        $this->setElementsPath();

        /**
         * Обрабатываем изображения
         */
        $this->resizeImages();

        $this->IncludeComponentTemplate();
    }

    /**
     * Функция для получения идентификатора товара на странице которого мы находимся
     * @return array|false
     */
    protected function getProductID()
    {
        Loader::includeModule('iblock');

        $exeQuery = new Query(ElementTable::getEntity());

        return $exeQuery->setSelect(array('ID'))->setFilter(array('CODE' => $this->arParams['ELEMENT_CODE']))
            ->setLimit(1)->exec()->Fetch();
    }

    /**
     * Функция для получения массива с данными связанных продуктов
     * @return mixed
     */
    protected function getProductsArray()
    {
        Loader::includeModule('iblock');

        $exeQuery = new Query(ElementTable::getEntity());

        return $exeQuery->setSelect(array('ID', 'CODE', 'NAME', 'PREVIEW_PICTURE'))
            ->setFilter(array('ID' => $this->arPropValues))->setLimit(5)->exec()->FetchAll();

    }

    /**
     * Функция для получения массива-списка с идентификаторами связанных продуктов
     */
    protected function setPropListValues()
    {
        $filter = array('ID' => $this->arParams['PROPERTY_ID']);

        $dbProp = \CIBlockElement::getProperty($this->arParams['IBLOCK_ID'], $this->getIntElementId(),
            array("sort" => "asc"), $filter);

        while ($ob = $dbProp->GetNext())
        {
            $values[] = $ob['VALUE'] ;
        }

        $this->arPropValues = $values;
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
     * Функция сеттер для записи защищенной переменной с идентификатором товара
     * @param $int_ind
     */
    protected function setIntElementId($intInd)
    {
        $this->intElementId = $intInd;
    }

    /**
     * Функция геттер для получения идентфикатора товара из защищенной переменной класса
     * @return mixed
     */
    protected function getIntElementId()
    {
        return $this->intElementId;
    }

    /**
     * Получаем путь к элементу по шаблону
     * @param $id
     */
    protected function setElementsPath()
    {
        /**
         * Получаем коллекцию идентификаторов выводимых элементов
         */
        for($i = 0; $i < count($this->arResult['ITEMS']); $i++)
        {
            $ids[] = $this->arResult['ITEMS'][$i]['ID'];
        }

        /**
         * Делаем запрос для получения сформированного DETAIL_PAGE_URL
         */
        $dbElements = CIBlockElement::GetList(array(), array("ID" => $ids), false, false,
            array("DETAIL_PAGE_URL"));

        /**
         * Записываем в массив arResult полученный DETAIL_PAGE_URL поиндексно
         */
        $index = 0;
        while($urlElements = $dbElements->getNext()['DETAIL_PAGE_URL'])
        {
            $this->arResult['ITEMS'][$index]['DETAIL_PAGE_URL'] = $urlElements;
            $index++;
        }
    }

}

?>