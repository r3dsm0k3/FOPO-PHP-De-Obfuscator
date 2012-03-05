#!/usr/bin/php
<?php
fwrite(STDOUT, "
       
     /**
     * ----------------------------------------------------------------------------
     * 'THE BEER-WARE LICENSE' (Revision 42):
     * <r3dsm0k3-ajithredsmoke@gmail.com> wrote this file. As long as you retain this notice you
     * can do whatever you want with this stuff. If we meet some day, and you think
     * this stuff is worth it, you can buy me a beer in return.-r3dsm0k3
     * ----------------------------------------------------------------------------
     **/

    /**
     * PHP De-Obfuscator for http://fopo.com.ar 
     *
     * @authors r3dsm0k3 & Himanshu (For nullcon JailBreak CTF 2012)
     * Works with low and medium level obfuscations completely,talking about hard,it converts 90% of the code,but variable names.
     *
     * @pre-requisite
     *
     * You should have the php & php cli module installed for this to use.
     * You can check this by opening a terminal and typing 'php -v' (without the quotes).It would display version information if installed.
     *
     * @usage
     * php debofus.php inputfilename.php outputfilename.php
     *           OR
     * chmod +x deobfus.php
     * ./deobfus.php inputfilename.php outputfilename.php
     *
     * @return Writes the de-obfuscated code to the specified output file.If no output filename is provided,creates decoded.php in the same directory.
     * Makes the script readable,But better use jsbeautifier.org or something for beautification of code.
     * 
     **/
     
     ");
    if($argv[1]!=""){
        
        $contents = file_get_contents($argv[1]);
        $eval = explode('(',$contents);
        $base64 =  explode ('"',$eval[2]);
        list($i,$wanted) = explode("eval",base64_decode($base64[1]));
        list($ni,$wanted2) = explode("))))",$wanted);
        list($nni,$obfuscated) = explode('"',$ni);
        $decoded = "<?php ".gzinflate(base64_decode(str_rot13($obfuscated)));
        $beautified = indent_proper($decoded);
        $result = preg_split('/"/', $beautified);
        foreach ($result as $r){
            if(preg_match("/^\\\\/", $r, $matches)){
                //TODO
                $beautified = str_ireplace('"'.$r.'"','"'.stripcslashes($r).'"',$beautified);
                $beautified = str_ireplace("'".$r."'","'".stripcslashes($r)."'",$beautified);
            }
        };
        $out = write_to_file($beautified,$argv[2]);
        $link = basename($out); 
        echo "File Wrote to ".$link."\n\n";
        
    }else{
        echo "\nPlease provide the input file name,RTFM Dude,RTFM.!\n\n";
    }
    exit(0);
    
/*Helper functions-Not many though*/
function indent_proper($text){
    $v1= str_replace("}","\n}\n",str_replace("{","{\n",str_replace(";",";\n",$text)));
    return str_replace("return","\n return",str_replace("<?php","\n<?php",$v1));
}

function write_to_file($string_data,$outname){
    if($outname=="")
        $outname = "decoded.php";
    $fh = fopen($outname, 'w') or die("can't open file");
    fwrite($fh, $string_data);
    fclose($fh);
    return $outname;
}
?>
