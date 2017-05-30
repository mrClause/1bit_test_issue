<?

class SimpleCatalog extends CBitrixComponent
{

    private $arDefaultUrlTemplates404;
    private $arDefaultVariableAliases404;
    private $arDefaultVariableAliases;
    private $arComponentVariables;
    private $arVariables;
    private $arVariableAliases;
    private $arUrlTemplates;

    /**
     * Перегружаем дефолтный конструктор класса
     * @param null $component
     */
    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->arDefaultUrlTemplates404 = array(
            "sections" => "",
            "section" => "#SECTION_CODE#/",
            "element" => "#SECTION_CODE#/#ELEMENT_CODE#/"
        );

        $this->arDefaultVariableAliases404 = array();
        $this->arDefaultVariableAliases = array();
        $this->arComponentVariables = array();
        $this->arVariables = array();
    }

    /**
     * Исполнение компонента.
     */
    public function executeComponent()
    {
        $this->arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($this->arDefaultUrlTemplates404,
                $this->arParams["SEF_URL_TEMPLATES"]);

        $this->arVariableAliases = CComponentEngine::MakeComponentVariableAliases($this->arDefaultVariableAliases404,
                $this->arParams["VARIABLE_ALIASES"]);

        $componentPage = CComponentEngine::ParseComponentPath($this->arParams["SEF_FOLDER"], $this->arUrlTemplates,
            $this->arVariables);

        CComponentEngine::InitComponentVariables($componentPage, $this->arComponentVariables, $this->arVariableAliases,
            $this->arVariables);

        $this->assignResult($componentPage);

        $this->IncludeComponentTemplate($componentPage);
    }

    /**
     * Формируем arResult(arParams) для вызова подкомпонентов
     * @param $componentPage
     */
    protected function assignResult($componentPage)
    {
        if(!$componentPage)
        {
            $componentPage = "sections";
        }

        switch ($componentPage)
        {
            case 'sections':
                $this->arResult = array(
                    "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
                    "FOLDER" => $this->arParams["SEF_FOLDER"],
                    "URL_TEMPLATES" => $this->arUrlTemplates,
                    "VARIABLES" => $this->arVariables,
                    "ALIASES" => $this->arVariableAliases,
                    "FILTER" => $this->arParams["FILTER"],
                    "SECTION_CODE" => $this->getArVariables['SECTION_CODE'],
                    "ORDER" => $this->arParams["ORDER"],
                    "LIMIT" => $this->arParams["LIMIT"],
                    "FIELD_TO_SECTION" => $this->arParams["FIELD_TO_SECTION"],
                    "SEF_VARIABLES" => $this->arParams["SEF_VARIABLES"],
                    "PAGE_404" => $this->arParams["PAGE_404"],
                );
                break;
            case 'section':
                $this->arResult = array(
                    "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
                    "FOLDER" => $this->arParams["SEF_FOLDER"],
                    "URL_TEMPLATES" => $this->arUrlTemplates,
                    "VARIABLES" => $this->arVariables,
                    "ALIASES" => $this->arVariableAliases,
                    "FILTER" => $this->arParams["FILTER"],
                    "SECTION_CODE" => $this->arVariables['SECTION_CODE'],
                    "ORDER" => $this->arParams["ORDER"],
                    "LIMIT" => $this->arParams["LIMIT"],
                    "FIELD_TO_SECTION" => $this->arParams["FIELD_TO_SECTION"],
                    "PAGE_404" => $this->arParams["PAGE_404"],
                );
                break;
            case 'element':
                $this->arResult = array(
                    "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
                    "FOLDER" => $this->arParams["SEF_FOLDER"],
                    "URL_TEMPLATES" => $this->arUrlTemplates,
                    "VARIABLES" => $this->arVariables,
                    "ALIASES" => $this->arVariableAliases,
                    "FILTER" => $this->arParams["FILTER"],
                    "SECTION_CODE" => $this->arVariables['SECTION_CODE'],
                    "ELEMENT_CODE" => $this->arVariables['ELEMENT_CODE'],
                    "ORDER" => $this->arParams["ORDER"],
                    "LIMIT" => $this->arParams["LIMIT"],
                    "FIELD_TO_SECTION" => $this->arParams["FIELD_TO_SECTION"],
                    "FIELD_TO_DETAIL" => $this->arParams["FIELD_TO_DETAIL"],
                    "RELATED_PROPERTY_IDS" => $this->arParams["RELATED_PROPERTY_IDS"],
                    "PAGE_404" => $this->arParams["PAGE_404"],
                );
                break;
        }
    }
}
?>

