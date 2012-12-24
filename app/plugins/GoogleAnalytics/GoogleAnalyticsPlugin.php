<?php
/* ----------------------------------------------------------------------
 * GoogleAnalyticsPlugin.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com) - Copyright 2012 Whirl-i-Gig
 * For this plugin : created by idéesculture (http://www.ideesculture.com)
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	class GoogleAnalyticsPlugin extends BaseApplicationPlugin {
		# -------------------------------------------------------
		public function __construct($ps_plugin_path) {
			$this->description = _t('Adds Google Analytics functionality to Pawtucket');
			$this->opo_config = Configuration::load($ps_plugin_path.'/conf/GoogleAnalytics.conf');
			$account=$this->opo_config->get('account');
			$googleAnalyticsCode = "\n// GoogleAnalytics \n var _gaq = _gaq || []; _gaq.push(['_setAccount', '^account']); _gaq.push(['_trackPageview']); \n (function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })(); \n";
			// If a defined GoogleAnalytics account is defined, include the javascript code 
			if ($account) {
				$googleAnalyticsCode = str_replace("^account",$account,$googleAnalyticsCode);
				JavascriptLoadManager::addComplementaryScript($googleAnalyticsCode);
			}
			parent::__construct();
		}
		# -------------------------------------------------------
		/**
		 * checkStatus() returns true only if the GoogleAnalytics account is properly defined in the conf file
		 */
		public function checkStatus() {
			$errors=array();
			$available=(bool)$this->opo_config->get('enabled');
			if (!$this->opo_config->get("account")) {
				$error=array(1 => "Google Analytics account not defined.");
				$available=false;
			}
			return array(
				'description' => $this->getDescription(),
				'errors' => $errors,
				'warnings' => array(),
				'available' => $available
			);
		}
		# -------------------------------------------------------
		/**
		 * Get plugin user actions
		 */
		static public function getRoleActionList() {
			return array();
		}
		# -------------------------------------------------------
	}
?>