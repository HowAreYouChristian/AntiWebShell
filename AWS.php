<?php
/*
    
 (`-')  _  <-. (`-')_ (`-')        _               .->    (`-')  _ <-.(`-')       (`-').->  (`-').->  (`-')  _                     
 (OO ).-/     \( OO) )( OO).->    (_)          (`(`-')/`) ( OO).-/  __( OO)       ( OO)_    (OO )__   ( OO).-/    <-.       <-.    
 / ,---.   ,--./ ,--/ /    '._    ,-(`-')     ,-`( OO).',(,------. '-'---.\      (_)--\_)  ,--. ,'-' (,------.  ,--. )    ,--. )   
 | \ /`.\  |   \ |  | |'--...__)  | ( OO)     |  |\  |  | |  .---' | .-. (/      /    _ /  |  | |  |  |  .---'  |  (`-')  |  (`-') 
 '-'|_.' | |  . '|  |)`--.  .--'  |  |  )     |  | '.|  |(|  '--.  | '-' `.)     \_..`--.  |  `-'  | (|  '--.   |  |OO )  |  |OO ) 
(|  .-.  | |  |\    |    |  |    (|  |_/      |  |.'.|  | |  .--'  | /`'.  |     .-._)   \ |  .-.  |  |  .--'  (|  '__ | (|  '__ | 
 |  | |  | |  | \   |    |  |     |  |'->     |   ,'.   | |  `---. | '--'  /     \       / |  | |  |  |  `---.  |     |'  |     |' 
 `--' `--' `--'  `--'    `--'     `--'        `--'   '--' `------' `------'       `-----'  `--' `--'  `------'  `-----'   `-----'  V.1
Proof Of Concept AntiWebShell | Christian Ronaldo Sopaheluwakan | 672016226@student.uksw.edu | Educational Purpose Only

REGEX FORMULA :
[a-zA-Z0-9\+V]{100,}

*/
    set_time_limit(999999);

    class AntiWebShell{
        private $backdoorStrings = [
            "passthru.*.\\\$_(GET|POST)", "exec.*.\\\$_(GET|POST)",
            "shell_exec.*.\\\$_(GET|POST)", "system.*.\\\$_(GET|POST)",
            "extract.*.\\\$_(GET|POST)", "extract.*.\\\$_REQUEST", "edoced_46esab",
            "HTTP_USER_AGENT",

            // SPECIFIC CASE //
            /* base64_decode may be false positive => */ "base64_decode",
            /* dynamic functions may be false positive => */ "\\\$\\w+\\s*\\(",
            // scanning results on vendor folder or any CMS may be MUCH FALSE POSITIVE

            // Add more backdoor strings below (Support REGEX)
            "indoxploit", "galerz", "backdoor", "php-cgi-shell", "cgi-shell", "convert_uu", "shell_data", "getimagesize", "magicboom",
            "php shell", "deface", "symlink", "adminer", "zone-h" , "zoneh", "defacer.id", "defacer id", "brute force", "error_reporting",
            "b374k", "FATHURFREAKZ", "exec", "shell_exec", "fwrite", "str_replace", "mail", "file_get_contents", "url_get_contents",
			"substr", "__file__", "__halt_compiler", "base64_encode", "base64_decode", "eval", "gzinflate", "str_rot13", "c99shell",
			"phpspypass", "Owned", "hacker", "h4x0r", "/etc/passwd", "uname -a", "eval(base64_decode(", "(0xf7001E)?0x8b:(0xaE17A)", "d06f46103183ce08bbef999d3dcc426a",
			"rss_f541b3abd05e7962fcab37737f40fad8", "r57shell", "Locus7s", "milw0rm.com", "$IIIIIIIIIIIl", "SubhashDasyam.com", "31337", "adminer", "mysql", "idx_config",
			"exploit-db.com", "wso", "r57", "weevely", "alfa shell", "0byt3m1n1 Shell", "AK-47 Shell", "Marion001 Shell", "Mini Shell", "p0wny-shell", "Sadrazam Shell", "Webadmin Shell",
			"Wordpress Shell", "Simple Shell", "Pouya Shell", "Kacak Asp Shell", "Asp Cmd (Old ISS)", "Asp Cmd (New ISS)"


        ];

        private $exactlyMatches = 5; // Aggressive level (less is more aggressive)

        /*

        STOP !!! Do Not EDIT unless you're experienced with coding :)
        
        */

        private $exactlyPattern;
		public $exactlyNum = 0;
        private $scanResults;
		
		//Spesific
        public function scan($files){

            $backdoorPattern = "@(" . implode("|",$this->backdoorStrings) . ")@i";
            $exactlyPattern = "@(htaccess|system.*.\\(|phpinfo.*.\\(|base64_decode.*.\\(|chmod|create_function|mkdir|fopen.*.\\(|readfile.*.\\(|(eval|passthru|shell_exec|exec))@i";

            foreach($files as $file){
                $fileContent = file_get_contents($file);

                if(preg_match($backdoorPattern, $fileContent)){
                    $this->scanResults[] = $file;
                    $this->exactlyNum++;
                    continue;
                }

                if(preg_match_all($exactlyPattern,$fileContent,$matches)){
                    foreach($matches[0] as $match){
                        $this->exactlyPattern[$match] = 1;
                    }
                    $totalPattern = count($this->exactlyPattern);
                    $this->exactlyPattern = [];
                    if($totalPattern >= $this->exactlyMatches){
                        $this->scanResults[] = $file;
                        $this->exactlyNum++;
                    }
                }
            }
			
            return $this->scanResults;
        }
        
		//Massive
        public function scanAllDir($dir, $results = array()){
            $files = scandir($dir);

            foreach($files as $file){
                $path = realpath($dir . DIRECTORY_SEPARATOR . $file);
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                if(!is_dir($path)){
                    if($extension == "php" && $path != __FILE__)
                        $results[] = $path;
                }else if($file != "." && $file != ".."){
                    $results = $this->scanAllDir($path, $results);
                }
            }

            return $results;
        }
	
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AntiWebShell</title>
	<link rel="shortcut icon" href="https://img.icons8.com/flat_round/512/000000/hearts.png">
</head>
<body>
    <h1>AWS Scannner</h1>
    <form action="" method="GET">
        <p><b>Directory Path :</b></p>
        <input type="text" name="path">
        <input type="submit" value="Scan">
    </form>

    <?php
        if(isset($_GET["path"])){
            $scanner = new AntiWebShell();
            $files = $scanner->scanAllDir($_GET["path"]);
            $scannedFiles = $scanner->scan($files);

            if($scannedFiles != NULL){

                echo "<h3>$scanner->exactlyNum Backdoor detected !</h3>";
                echo "<span style='color:red;'>Scan results on vendor folder and base64_decode functions or any CMS may be FALSE POSITIVE</span><br><br>";

                foreach($scannedFiles as $backdoor){
                    echo $backdoor . "<br>";
                }

            }else{
                echo "<h3>Your system tendency is safe.</h3>";
            }
        }
    ?>

</body>
</html>
