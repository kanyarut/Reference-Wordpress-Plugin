<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
    <title>Google Book Search Embedded Viewer API Example</title> 
    <style type="text/css" >
    body,html{
    	padding: 0;
    	margin: 0;
    	width: 100%;
    	height: 100%;
    	overflow: hidden;
    }
    </style>
    <script type="text/javascript" src="//www.google.com/jsapi"></script> 
    <script type="text/javascript"> 
      google.load("books", "0");
 
      function initialize() {
        var viewer = new google.books.DefaultViewer(document.getElementById('viewerCanvas'));
        viewer.load('ISBN:<?php echo $_GET['isbn'] ?>', alertNotFound);
      }
      
     function alertNotFound() {
     	alert('Cannot load this book for preview');
     	parent.jQuery.fn.colorbox.close(); 
	  }

      google.setOnLoadCallback(initialize);
      
    </script> 
  </head> 
  <body> 
    <div id="viewerCanvas" style="width: 100%; height: 96%; margin: 0 auto;"></div> 
  </body> 
</html>