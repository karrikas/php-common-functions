<?php
class irudia //ArgazkiakTratatu
{
        var $helbidea;
        var $zabalera;
        var $altuera;
        var $mota;
        var $source;
        var $irudi_motak = array('gif','jpeg','jpg','png');
 
        /**
         * Clase hasi eta memoria reserbatzen dugu
         * @param int $mega
         */
        function irudia( $mega = 40 ){
                //objetua sortzerakoan orriaren memoria haunditzen dugu
                $this->set_memory_limit($mega);
        }
		
        /**
         * Lana egiteko irudiaren iturria zehazten da
         * @param string $artxibo_helbidea
         * @return bool
         */
        function helbidea( $artxibo_helbidea ) //irudia eskuratzen dugu
        {
                if( $this -> ongi( $artxibo_helbidea ) ){
                        return TRUE;
                }else{
                        return FALSE;
                }
        }
        
        function set_memory_limit($mega){
        	ini_set( "memory_limit", $mega ."M" );
        }
 
        /**
         * Altuera eta zabalera zehaztuz irudi maten miniatura lortu
         * @param $zabalera
         * @param $altuera
         * @param $izena
         * @param $kalitatea
         * @return binary src
         */
		function thumb( $zabalera = 100, $altuera = 100, $izena="", $kalitatea=100 ){
 
                //proportzioak lortu jakiteko nondik moztu
                $aldea = ($zabalera * 100) / $this -> zabalera;
                $luzea = ($altuera * 100) / $this -> altuera;
 
                if( $aldea >= $luzea ){
                        $originalaH = $this -> zabalera;
                        $originalaB =  ((($altuera * 100) / $zabalera) * $this -> zabalera) / 100;
                }else{
                        $originalaH = ((($zabalera * 100) / $altuera) * $this -> altuera) / 100;
                        $originalaB =  $this -> altuera;
                }
 
                //originala eskuratzen dugu
                $jatorria = $this->get_src();
 
                // Irudia lortzen dugu
                $emaitza = imagecreatetruecolor( $zabalera, $altuera );
 
                // Tama�a aldatzen da
                imagecopyresampled( $emaitza, $jatorria, 0, 0, 0, 0, $zabalera, $altuera, $originalaH, $originalaB );
                ImageDestroy( $jatorria );
 
				// motaren arabera emaitza eman
				return $this->set_src($emaitza,$izena,$kalitatea);
 
        }
        
        /**
         * Irudi baten miniatura egiten du proportzioak errespetatuz
         * eta utsuneak txuriz beteaz
         * @param $zabalera
         * @param $altuera
         * @param $izena
         * @param $kalitatea
         * @return binary src
         */
		function fill_thumb( $zabalera = 100, $altuera = 100, $izena="", $kalitatea=100 ){
		
			if($zabalera < $this -> zabalera || $this -> altuera > $altuera){
				if($this -> zabalera/$zabalera > $this -> altuera/$altuera){
					$ratio=$zabalera/$this -> zabalera;
				}else{ 
					$ratio=$altuera/$this -> altuera;
				}
				
				$img_w=round($ratio*$this -> zabalera); 
				$dist_x=($zabalera-$img_w)/2;
				$img_h=round($ratio*$this -> altuera); 
				$dist_y=($altuera-$img_h)/2;
			}else{
				$img_w=$this -> zabalera;
				$dist_x=($zabalera-$img_w)/2;
				$img_h=$this -> altuera;
				$dist_y=($altuera-$img_h)/2;
			}
		
			//originala eskuratzen dugu
			$jatorria = $this->get_src();
			
			// Irudia lortzen dugu
			$emaitza = imagecreatetruecolor( $zabalera, $altuera );
			
			// atzeko kolorea jarri
			$color = imagecolorallocate($emaitza,0xFF,0xFF,0xFF);
			imagefilledrectangle($emaitza, 0, 0, $zabalera, $altuera, $color);
			
			// Tama�a aldatzen da
			imagecopyresampled( $emaitza, $jatorria, $dist_x, $dist_y, 0, 0, $img_w, $img_h, $this -> zabalera, $this -> altuera );
			ImageDestroy( $jatorria );
			 
			// motaren arabera emaitza eman
			return $this->set_src($emaitza,$izena,$kalitatea);
		}
  
		/**
		 * Erabilitako memoria eskuratzen du
		 * @param $mota B(Byte)|KB(KiloByte)|MB(MegaByte)
		 * @return float
		 */
        function ram( $mota = 'KB' ) //erabilitako memoria erakusten du
        {
 
                $erabilitakoMemoria = memory_get_usage();
                switch( $mota ){
                        case "B":
                                $emaitza = $erabilitakoMemoria;
                                break;
                        case "KB":
                                $emaitza = round( $erabilitakoMemoria/1024, 2);
                                break;
                        case "MB":
                                $emaitza = round( ($erabilitakoMemoria/1024)/1024, 2);
                                break;
                }
 
                return $emaitza;
        }
 
        function ongi( $helbidea ) //irudia topatzen duen jakiteko
        {
                if( !file_exists( $helbidea ) )
                {
					return FALSE;
                }
                
                $this -> helbidea = $helbidea;
                $this -> BalioakGorde( $helbidea );
                if(!in_array($this->mota,$this->irudi_motak))
                {
                	return FALSE;
                }
                
                return TRUE;
        }
 
        function BalioakGorde( $artxiboa ) //datuak gordetzen digutugu ondorengo aldaketentzat
        {
                $array_img = getimagesize( $this -> helbidea );
                $this -> zabalera = $array_img[0];
                $this -> altuera = $array_img[1];
                switch( $array_img[2] )
                {
                        case 1:
                                $this -> mota = "gif";
                                break;
                        case 2:
                                $this -> mota = "jpg";
                                break;
                        case 3:
                                $this -> mota = "png";
                                break;
                }
        }
        function zabalera( $zabalera, $izena = "", $kalitatea = 100 ){ //zabalera zahaztuta irudia itzuliko dugu
 
                $jatorria = $this->get_src();
 
                //altuera berria kalulatzen dugu
                $altuera = ( $zabalera * $this -> altuera ) / $this -> zabalera;
 
                //altuera berria kalkulatu
                $zabalera_berria = $zabalera;
                $altuera_berria = $altuera;
 
                //altuera zaharrak lortu
                $altuera_originala            = $this -> altuera;
                $zabalera_originala     = $this -> zabalera;
 
                //deformaziorik ez
                if( $zabalera > $altuera ){
                        $altuera_originala = ( $altuera * $this -> zabalera ) / $zabalera;
                } else {
                        $zabalera_originala = ( $zabalera * $this -> altuera ) / $altuera;
                }
 
                // Irudia lortzen dugu
                $emaitza = imagecreatetruecolor( $zabalera_berria, $altuera_berria );
 
                // Tama�a aldatzen da
                imagecopyresampled( $emaitza, $jatorria, 0, 0, 0, 0, $zabalera_berria, $altuera_berria, $zabalera_originala, $altuera_originala );
                ImageDestroy( $jatorria );
 
                //emaitza itzuli edo gorde
                return $this->set_src($emaitza,$izena,$kalitatea);
        }
 
        function altuera( $altuera, $izena = "", $kalitatea = 100 ){ //altuera zahaztuta irudia itzuliko dugu
 
                 $jatorria = $this->get_src();
 
                //altuera berria kalulatzen dugu
                $zabalera = ( $altuera *  $this -> zabalera ) / $this -> altuera;
 
                //altuera berria kalkulatu
                $zabalera_berria = $zabalera;
                $altuera_berria = $altuera;
 
                //altuera zaharrak lortu
                $altuera_originala            = $this -> altuera;
                $zabalera_originala     = $this -> zabalera;
 
                //deformaziorik ez
                if( $zabalera > $altuera ){
                        $altuera_originala = ( $altuera * $this -> zabalera ) / $zabalera;
                } else {
                        $zabalera_originala = ( $zabalera * $this -> altuera ) / $altuera;
                }
 
                // Irudia lortzen dugu
                $emaitza = imagecreatetruecolor( $zabalera_berria, $altuera_berria );
 
                // Tama�a aldatzen da
                imagecopyresampled( $emaitza, $jatorria, 0, 0, 0, 0, $zabalera_berria, $altuera_berria, $zabalera_originala, $altuera_originala );
                ImageDestroy( $jatorria );
 
                //emaitza itzuli edo gorde
				return $this->set_src($emaitza,$izena,$kalitatea);
        }
        
		function get_src(){
			switch( $this -> mota ){
				case "gif":
					$src = imagecreatefromgif( $this -> helbidea );
					break;
				case "jpg":
					$src = imagecreatefromjpeg( $this -> helbidea );
					break;
				case "png":
					$src = imagecreatefrompng( $this -> helbidea );
					break;
			}
			return $src;
		}

		function set_src($src,$name='',$quality=100){
			switch( $this -> mota ){
				case "gif":
                                        header('Content-Type: image/gif');
					imagegif($src, $name);
					break;
				case "jpg":
                                        header('Content-Type: image/jpeg');
					imagejpeg( $src, $name, $quality );
					break;
				case "png":
                                        header('Content-Type: image/png');
					imagepng( $src, $name, $quality );
					break;
			}
			ImageDestroy( $src );
		}
 
 
 
        function horizontala() //bidali horizontala true
        {
                if( $this -> zabalera > $this -> altuera ){
                        return TRUE;
                } else {
                        return FALSE;
                }
        }
 
        function bertikala() //bidali bertikala true
        {
                if( $this -> zabalera < $this -> altuera ){
                        return TRUE;
                } else {
                        return FALSE;
                }
        }
 
        function info() //irudiaren informazioa bidaltzen du
        {
                $datuak = array();
                $datuak["helbidea"] =   $this -> helbidea;
                $datuak["zabalera"] =   $this -> zabalera;
                $datuak["altuera"]      =    $this -> altuera;
                $datuak["mota"]         =       $this -> mota;
 
                return $datuak;
        }
}
?>