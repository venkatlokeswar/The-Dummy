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
			if(is_array($route)){
				$route = $route['url'];
				$parts = explode("/", $route);
			}
			return $parts;
		}

		private function uri($part){
			$parts = explode("/", $_SERVER['REQUEST_URI']);	
			$path_name = explode("/", $_SERVER['SCRIPT_FILENAME']);
			array_splice($parts, count($parts)-2, 0, end($path_name));
			echo "<pre>";
			print_r($parts);
			if($parts[1] == $GLOBALS['config']['path']['index']){
			print_r($parts);
				$part++;
			}
			echo $_SERVER['REQUEST_URI'];
			return isset($parts[$part])?$parts[$part]:"";
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
			$defaultController = $this->uri(1);
			$defaultMethod = $this->uri(2);


			echo $defaultMethod."<br>";
			echo $defaultController;
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
			print_r($route);
			return $route;
		}
	}
?>
