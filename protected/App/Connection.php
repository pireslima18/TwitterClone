<?php

	namespace App;

	class Connection{

		public static function getDb(){

			try{

				$conn = new \PDO(
					"mysql:host=localhost;dbname=twitter_clone",
					"root",
					""
				);
				
				// Define o conjunto de caracteres para utf8mb4
                $conn->exec("set names utf8mb4");
                
				return $conn;

			}catch(\PDOException $e){
				echo "Erro: ". $e;
			}

		}

	}

?>