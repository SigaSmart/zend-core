<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */


namespace Core\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements
    TableOptionsInterface,
    DataTableInterface,
    RenderInterface,
    PaginatorInterface
{

    /**
     * Name of table
     * @var null | string
     */
    protected $name = '';

    /**
     * Show or hide pagination view
     * @var boolean
     */
    protected $showPagination = true;

    /**
     * Show or hide pagination view
     * @var boolean
     */
    protected $showParamsWrap = true;

    /**
     * Show or hide quick search view
     * @var boolean
     */
    protected $showQuickSearch = false;


    /**
     * Show or hide item per page view
     * @var boolean
     */
    protected $showItemPerPage = true;

    /**
     * @todo item and default count per page
     * Default value for item count per page
     * @var int
     */
    protected $itemCountPerPage = 10;

    /**
     * Flag to show row with filters (for each column)
     * @var boolean
     */
    protected $showColumnFilters = false;

    /**
     * Definition of
     * @var string | boolean
     */
    protected $rowAction = false;


    /**
     * Show or hide exporter to CSV
     * @var boolean
     */
    protected $showExportToCSV = false;



    /**
     * Value to specify items per page (pagination)
     * @var array
     */
    protected $valuesOfItemPerPage = array(5, 10, 20, 50 , 100);


    /**
    * Get maximal rows to returning. Data tables can use
    * pagination, but also can get data by ajax, and use
    * java script to pagination (and variable destiny for this case)
    *
    * @var int
    */
    protected $dataTablesMaxRows = 999;


    /**
     * Template Map
     * @var array
     */
    protected $templateMap = [];

	/**
	 * Value to specify items status
	 * @var array
	 */
	protected $valuesOfState = [null => 'All' , 1 => 'Active' , 2 => 'Inactive', 3 => 'Trash'];

	/**
	 * Value to specify items $valueButtonsActions
	 * @var array
	 */
	protected $valueButtonsActions = ['add'=>"Adicionar",'active'=>'Ativar','inactive'=>"Desabilitar","trash"=>"Enviar p/ Lixeira",'trashall'=>'Esvaziar Lixeira','csv'=>'Exportar'];

	/**
	 * Show or hide exporter to showButtonsActions
	 * @var boolean
	 */
	protected $showButtonsActions = true;

	/**
	 * Nome do modulo
	 * @var string
	 */
	protected $Module = 'Core';

	/**
	 * Nome da rota
	 * @var string
	 */
	protected $Route = "admin";

	/**
	 * Nome do controller
	 * @var string
	 */
	protected $Controller = "admin";
	/**
	 * @var int
	 */
	protected $numberColls = 3;


    public function __construct($options = null)
    {
        $this->templateMap = array(
                'paginator-slide' =>sprintf('%s/../../view/layout/%s/templates/slide-paginator.phtml',__DIR__, LAYOUT),
                'default-params' =>sprintf('%s/../../view/layout/%s/templates/default-params.phtml',__DIR__, LAYOUT),
                'container' => sprintf('%s/../../view/layout/%s/templates/container-b3.phtml',__DIR__, LAYOUT),
                'data-table-init' => sprintf('%s/../../view/layout/%s/templates/data-table-init.phtml',__DIR__, LAYOUT),
                'custom-b3' => sprintf('%s/../../view/layout/%s/templates/custom-b3.phtml',__DIR__, LAYOUT)
        );

        parent::__construct($options);
    }


    public function getShowExportToCSV()
    {
        return $this->showExportToCSV;
    }


    public function setShowExportToCSV($showExportToCSV)
    {
        $this->showExportToCSV = $showExportToCSV;
    }



    /**
     * Set template map
     * @param array $templateMap
     */
    public function setTemplateMap($templateMap)
    {
        $this->templateMap = array_merge( $this->templateMap, $templateMap);
    }


    /**
     * Set template map
     *
     * @return array
     */
    public function getTemplateMap()
    {
        return $this->templateMap;
    }

	/**
	 * @return array
	 */
	public function getModule()
	{
		return $this->Module;
	}

	/**
	 * @param  $Module
	 *
	 * @return ModuleOptions
	 */
	public function setModule($Module)
	{
		$this->Module = $Module;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRoute()
	{
		return $this->Route;
	}

	/**
	 * @param string $Route
	 *
	 * @return ModuleOptions
	 */
	public function setRoute(string $Route)
	{
		$this->Route = $Route;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getController()
	{
		return $this->Controller;
	}

	/**
	 * @param string $Controller
	 *
	 * @return ModuleOptions
	 */
	public function setController(string $Controller)
	{
		$this->Controller = $Controller;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getNumberColls()
	{
		return $this->numberColls;
	}

	/**
	 * @param int $numberColls
	 *
	 * @return ModuleOptions
	 */
	public function setNumberColls(int $numberColls)
	{
		$this->numberColls = $numberColls;
		return $this;
	}


	/**
	 * Get Array of values to set items status
	 * @return array
	 */
	public function getValuesOfState() {
		return $this->valuesOfState;
	}

	/**
	 * Get Array of values to set items showButtonsActios
	 * @return array
	 */
	public function getShowButtonsActions() {
		return $this->showButtonsActions;
	}

	/**
	 * Set Array of values to set items showButtonsActions
	 * @return $this
	 */
	public function setShowButtonsActions($showButtonsActions) {
		$this->showButtonsActions = $showButtonsActions;
		return $this;
	}

	/**
	 * Get Array of values to set items showButtonsActios
	 * @return array
	 */
	public function getValueButtonsActions() {
		return $this->valueButtonsActions;
	}

	/**
	 * Set Array of values to set items valueButtonsActions
	 * @return array
	 */
	public function setValueButtonsActions($valueButtonsActions) {
		$this->valueButtonsActions = array_merge($this->valueButtonsActions, $valueButtonsActions);
		return $this;
	}
	/**
	 *
	 * Set Array of values to set items status
	 *
	 * @param array $valuesOfState
	 * @return $this
	 */
	public function setValuesOfState($valuesOfState) {
		$this->valuesOfState = $valuesOfState;
		return $this;
	}



    /**
     * Get maximal rows to returning
     *
     * @return int
     */
    public function getDataTablesMaxRows()
    {
        return $this->dataTablesMaxRows;
    }

    /**
     * Set maximal rows to returning.
     *
     * @param int $dataTablesMaxRows
     * @return $this
     */
    public function setDataTablesMaxRows($dataTablesMaxRows)
    {
        $this->dataTablesMaxRows = $dataTablesMaxRows;
        return $this;
    }

    /**
     * Get Array of values to set items per page
     * @return array
     */
    public function getValuesOfItemPerPage()
    {
        return $this->valuesOfItemPerPage;
    }

    /**
     *
     * Set Array of values to set items per page
     *
     * @param array $valuesOfItemPerPage
     * @return $this
     */
    public function setValuesOfItemPerPage($valuesOfItemPerPage)
    {
        $this->valuesOfItemPerPage = $valuesOfItemPerPage;
        return $this;
    }


    public function getName()
    {
        return $this->name;
    }

    public function getShowPagination()
    {
        return $this->showPagination;
    }

    public function getShowQuickSearch()
    {
        return $this->showQuickSearch;
    }

    public function getShowItemPerPage()
    {
        return $this->showItemPerPage;
    }

    public function getItemCountPerPage()
    {
        return $this->itemCountPerPage;
    }

    public function getShowColumnFilters()
    {
        return $this->showColumnFilters;
    }

    public function getRowAction()
    {
        return $this->rowAction;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setShowPagination($showPagination)
    {
        $this->showPagination = $showPagination;
    }

    public function setShowQuickSearch($showQuickSearch)
    {
        $this->showQuickSearch = $showQuickSearch;
    }

    public function setShowItemPerPage($showItemPerPage)
    {
        $this->showItemPerPage = $showItemPerPage;
    }

    public function setItemCountPerPage($itemCountPerPage)
    {
        $this->itemCountPerPage = $itemCountPerPage;
    }

    public function setShowColumnFilters($showColumnFilters)
    {
        $this->showColumnFilters = $showColumnFilters;
    }

    public function setRowAction($rowAction)
    {
        $this->rowAction = $rowAction;
    }

	/**
	 * @return bool
	 */
	public function getShowParamsWrap()
	{
		return $this->showParamsWrap;
	}

	/**
	 * @param bool $showParamsWrap
	 *
	 * @return ModuleOptions
	 */
	public function setShowParamsWrap(bool $showParamsWrap)
	{
		$this->showParamsWrap = $showParamsWrap;
		return $this;
	}


}
