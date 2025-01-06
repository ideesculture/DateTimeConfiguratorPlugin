<?php

class DateTimeController extends ActionController {
	# -------------------------------------------------------
	protected $config;
    protected $opo_datetime_settings;

	# -------------------------------------------------------
	# Constructor
	# -------------------------------------------------------

	public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
        // Load plugin configuration file
		$this->config = Configuration::load(__CA_APP_DIR__.'/plugins/DateTimeConfigurator/conf/DateTimeConfigurator.conf');
        $this->opo_datetime_settings = Configuration::load(__CA_CONF_DIR__.'/datetime.conf');
		
		if (!$this->config->get('enabled')) {
			throw new ApplicationException(_t('DateTimeConfigurator plugin is not enabled'));
		}

		parent::__construct($po_request, $po_response, $pa_view_paths);
	}
	# -------------------------------------------------------
	public function Index() {
        $this->view->setVar('expressions',  $this->opo_datetime_settings->get("expressions"));
		$yearStart = $this->request->getParameter('yearStart', pInteger);
		$yearEnd = $this->request->getParameter('yearEnd', pInteger);
		$this->view->setVar("yearStart", $yearStart);
		$this->view->setVar("yearEnd", $yearEnd);
		$this->render("index_html.php");
	}

    public function Editor() {
        $this->view->setVar('expressions',  $this->opo_datetime_settings->get("expressions"));
		$this->render("editor_html.php");
	}
}
