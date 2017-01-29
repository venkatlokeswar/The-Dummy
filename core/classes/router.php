<?php
	class router{

		private $routes;

		function __construct(){
			$this->routes = $GLOBALS['config']['routes'];
			$route = $this->findRoute();

			if(class_exists($route['controller'])){
				$controller = new $route['controller']();
				if(method_exists($controller, $route['method'])){
					$controller->$route['method']();
				}
				else{
					error::show(404);
				}
			}
			else{
				error::show(404);
			}
		}

		private function routePart($route){
			
			return explode("/", $route);
		}

		private function isBasePath($path){

			if(basename($path)=='index.php'){
				return true;
			}
			else{
				return false;
			}
		}

		private function uri($part){
			$parts = explode("/", $_SERVER['REQUEST_URI']);	
			$self_parts = explode("/", $_SERVER['PHP_SELF']);
			if(count($parts) == count($self_parts)){
				return "";
			}
			if(count($parts) > count($self_parts)){
				return isset($parts[count($parts)-$part])?$parts[count($parts)-$part]:"";
			}
		}

		private function findRoute(){
			foreach($this->routes as $route){

				$parts = $this->routePart($route);
				$allMatch = true;
				foreach ($parts as $key => $value) {
					if( $value !== "*" ){
						if($this->uri($key) !== $value){
							$allMatch = false;
						}
					}
				}
				if($allMatch){
					return $route;
				}
			}
			$defaultController = $this->uri(2);
			$defaultMethod = $this->uri(1);



			if($defaultController == "" ){
				$defaultController = $GLOBALS['config']['defaults']['controller'];
			}
			if($defaultMethod == ""){
				$defaultMethod = $GLOBALS['config']['defaults']['method'];
			}
		 
			$route = array(
				'controller' =>	$defaultController,
				'method'	 =>	$defaultMethod
			);
			return $route;
		}
	}
?>
