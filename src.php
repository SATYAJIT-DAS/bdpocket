<?php
if(isset($_REQUEST['search']) && $_REQUEST['search']!='')
{
	$searchfor = $_REQUEST['search'];	
	$currentDir=getcwd();
	ListFolder($currentDir,$searchfor);
}else{
	$searchfor='';
}


function ListFolder($path,$searchfor)
{    
    $dir_handle = @opendir($path) or die("Unable to open $path");   
    
	if(strstr($path, '/')){
		$dirname = @end(explode("/", $path));
	}else{
		$dirname=@end(explode("\\", $path));;
	}
    
    echo ("<li class=\"folder\">$dirname");
	
    echo "<ul>\n";
    while (false !== ($file = readdir($dir_handle)))
    {
        if($file!="." && $file!="..")
        {
            if (is_dir($path."/".$file))
			{              
                ListFolder($path."/".$file,$searchfor);
            }
            else
            {               
				$contents = file_get_contents($path."/".$file);
				$pattern = preg_quote($searchfor, '/');
				$pattern = "/^.*$pattern.*\$/m";
				$virtualPath="http://".$_SERVER['HTTP_HOST'];
				if(preg_match_all($pattern, $contents, $matches)){
					echo "<li class=\"file\">".$path."/".$file."</li>";
				}
            }
        }
    }
    echo "</ul>\n";
    echo "</li>\n";   
   
    closedir($dir_handle);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search</title>
<style>
li.folder{
	background-image:url(http://scatterpost.org/images/folder.png) ;
	background-repeat:no-repeat;	
	padding: 3px 0 3px 25px;
	margin: .4em 0;			
}
li.file{
	background-image:url(http://scatterpost.org/images/file.png);
	background-repeat:no-repeat;
	background-position: 0 50%;
	padding: 3px 0 3px 25px;
	margin: .4em 0;
}
ul,li
{
list-style: none;
margin: 0;
padding: 0;
}

</style>
</head>

<body>
<form name="searchForm" action="" method="post">
	<input type="text" name="search" value="<?php echo $searchfor;?>" />
    <input type="submit" value="Search" />
</form>
</body>
</html>