<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.1" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" />   
   <xsl:variable name="title" select="/rss/channel/title"/>   
  <xsl:template match="/">
    <html>
      <head>
        <title>
          <xsl:value-of select="$title"/> XML Feed</title>
      <link rel="stylesheet" href="/modules/{{$module->GetModuleName()}}/rss/rss.css" type="text/css"/>
      
      </head> 
    <xsl:apply-templates select="rss/channel"/>   
    </html>
  </xsl:template>
  
    <xsl:template match="channel">
    <body>         
      <div class="topbox">
      <div class="padtopbox">
      <h2>What is this page?</h2>
      <p>This is an RSS feed from the <xsl:value-of select="image/title" /> website. RSS feeds allow you to stay up to date with the latest news and features you want from  <xsl:value-of select="image/title" />.</p>
      <p>To subscribe to it, you will need a News Reader or other similar device.</p>
      <p>
<a href="http://en.wikipedia.org/wiki/Rss"><strong>Help</strong>, I don't know what a news reader is and still don't know what this is about.</a><br clear="all" />
      </p>
      </div>
      </div>    
      
      <div class="banbox">
      <div class="padbanbox">     
      <div class="mvb">
      <div class="fltl"><span class="subhead">RSS Feed For: </span></div><a href="#" class="item"><xsl:value-of select="$title"/></a><br clear="all" />
       </div>
       
    
      </div>
      </div>    
      
      <div class="mainbox">
        <div class="itembox">
          <div class="paditembox">
          <xsl:apply-templates select="item"/>
          </div>
        </div>  
        <div class="rhsbox">
          <div class="padrhsbox">
          <h2>Subscribe to this feed</h2>
          <p>You can subscribe to this RSS feed in a number of ways, including the following:</p>
          <ul>
          <li>Drag the orange RSS button into your News Reader</li>
          <li>Drag the URL of the RSS feed into your News Reader</li>
          <li>Cut and paste the URL of the RSS feed into your News Reader</li>
          </ul>                               
          
          </div>    
        </div>  
      </div>  
      
    <div class="footerbox">

    </div>
        
    </body>
  </xsl:template>
    
  <xsl:template match="item">
  <div id="item">
  <ul>
      <li>
        <a href="{link}" class="item">
          <xsl:value-of disable-output-escaping="yes" select="title"/>
        </a><br/>     
        <div>
        <xsl:value-of disable-output-escaping="yes" select="description" />         
        </div>  
        </li>
    </ul>
  </div>    
  </xsl:template>
</xsl:stylesheet>