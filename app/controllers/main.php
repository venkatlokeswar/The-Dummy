<?php
	class main{
		function index(){
			echo "Main Index";
			echo "<a href='main/foo'>Click Here</a>";
		}

		
		function foo(){
			echo "Foo Method";
			echo "<a href='../'>Click Here</a>"; 
		}

		function exists(){
			echo "It Exists";
			echo "<a href='../'>Click Here</a>";  
		}

	}
?>