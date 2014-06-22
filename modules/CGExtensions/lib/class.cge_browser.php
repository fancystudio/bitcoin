<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide useful functions
#  and commonly used gui capabilities to other modules.
#
#-------------------------------------------------------------------------
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE

class cge_browser extends Browser
{
  protected function bulkCheckRobot()
  {
    $bot_list = array('Ezooms', 'MSNBot', 'bingbot', 'Mail.Ru bot', 'Googlebot', 'MJ12bot', 'UnisterBot', 'Baiduspider', 'GrapeshotCrawler', 
     'Genieo Web filter', 'bitlybot', 'YandexBot', 'ia_archiver', 'ExB Language Crawler', 'NaverBot', 'proximic', 
     'WebThumbnail', 'MetaJobBot', 'AddThis.com', 'Spinn3r', 'sogou spider', 'coccoc', 'ichiro', 'UASlinkChecker', 
     'uMBot-FC', 'Daumoa', 'Exabot', 'magpie-crawler', 'ChangeDetection', 'ZumBot', 'Netseer', 'Yahoo! JAPAN', 'Yahoo!', 
     'CareerBot', 'rogerbot', 'ShowyouBot', 'Butterfly', 'Infohelfer', 'Vagabondo', 'ShopWiki', 'sistrix', 'Woko', 
     'SemrushBot', 'YioopBot', 'Najdi.si', 'linkdexbot', 'SeznamBot', 'A6-Indexer', 'Vedma', 'AhrefsBot', 'archive.org_bot', 
     'yacybot', 'alexa site audit', 'SEOkicks-Robot', 'bixocrawler', 'Browsershots', 'spbot', 'HubSpot Connect', 'Jyxobot', 
     'TurnitinBot', 'aiHitBot', 'SearchmetricsBot', 'BLEXBot', 'CompSpyBot', 'psbot', 'TinEye', 'Nuhk', 'Wotbox', 'VoilaBot', 
     'Blekkobot', 'woriobot', 'netEstate Crawler', 'search.KumKie.com', 'NetcraftSurveyAgent', 'BUbiNG', '80legs', 'Aboundexbot', 
     'BingPreview', 'SEOENGBot', 'AraBot', 'SeoCheckBot', 'AMZNKAssocBot', 'linkdex.com', 'Cliqzbot', 'Speedy', 'meanpathbot', 'Plukkie', 
     'parsijoo', 'oBot', 'HostTracker', 'OpenWebSpider', 'WBSearchBot', ' FacebookExternalHit', 'socialbm_bot', 'KrOWLer', 'iCjobs', 
     'IstellaBot', 'CliqzBot', 'findlinks', 'IntegromeDB', 'FlipboardProxy', 'MojeekBot', 'SBSearch', 'Nigma.ru', 'Qualidator.com Bot', 
     'BacklinkCrawler', 'Peeplo Screenshot Bot', 'trendictionbot', 'Panscient web crawler', 'FyberSpider', 'CCResearchBot', 'Semantifire', 
     'LinkAider', 'Qirina Hurdler', 'Zookabot', 'Crawler4j', 'ScreenerBot Crawler', 'CloudServerMarketSpider', 'webmastercoffee', 
     'PaperLiBot', 'QuerySeekerSpider', 'Crowsnest', 'UnwindFetchor', 'MetaURI API', 'AcoonBot', 'Steeler', 'Gigabot', 'firmilybot', 
     'Sosospider', 'OpenindexSpider', 'MetaHeadersBot', 'Strokebot', 'GeliyooBot', 'CCBot', 'bot-pge.chlooe.com', 'ownCloud Server Crawler', 
     'CirrusExplorer', 'ProCogSEOBot', 'Falconsbot', 'Dlvr.it/1.0', 'thumbshots-de-Bot', '200PleaseBot', 'discoverybot', 'R6 bot', 
     'bl.uk_lddc_bot', 'SolomonoBot', 'Grahambot', 'Automattic Analytics Crawler', 'emefgebot', 'YoudaoBot', 'PiplBot', 
     'FlightDeckReportsBot', 'fastbot crawler', '4seohuntBot', 'Updownerbot', 'JikeSpider', 'NLNZ_IAHarvester2013', 'wsAnalyzer', 
     'YodaoBot', 'SpiderLing', 'Esribot', 'Thumbshots.ru', 'BlogPulse', 'NextGenSearchBot', 'bot.wsowner.com', 'wscheck.com', 
     'Qseero', 'drupact', 'HuaweiSymantecSpider', 'PagePeeker', 'HomeTags', ' facebookplatform', 'Pixray-Seeker', 'BDFetch', 
     'MeMoNewsBot', 'ProCogBot', 'WillyBot', 'peerindex', 'Job Roboter Spider', 'MLBot', 'WebNL', 'Peepowbot', 'Semager', 'MIA Bot', 
     'Eurobot', 'DripfeedBot', 'webinatorbot', 'Whoismindbot', 'Bad-Neighborhood', 'Hailoobot', 'akula', 'MetamojiCrawler', 'Page2RSS', 
     'EasyBib AutoCite', 'suggybot', 'NerdByNature.Bot', 'EventGuruBot', 'quickobot', 'gonzo', 'bnf.fr_bot', 'UptimeRobot', 'Influencebot', 
     'MSRBOT', 'KeywordDensityRobot', 'heritrix', 'Ronzoobot', 'RyzeCrawler', 'ScoutJet', 'Twikle', 'SWEBot', 'RADaR-Bot', 'DCPbot', 
     'Castabot', 'percbotspider', 'WeSEE:Search', 'CatchBot', 'imbot', 'EdisterBot', 'WASALive-Bot', 'Accelobot', 'PostPost', 'factbot', 
     'Setoozbot', 'biwec', 'GarlikCrawler', 'Search17Bot', 'Lijit', 'MetaGeneratorCrawler', 'Robots_Tester', 'JUST-CRAWLER', 'Apercite', 
     'pmoz.info ODP link checker', 'LemurWebCrawler', 'Covario-IDS', 'Holmes', 'RankurBot', 'DotBot', 'AdsBot-Google', 'envolk', 
     'Ask Jeeves/Teoma', 'LexxeBot', 'adressendeutschland.de', 'StackRambler', 'Abrave Spider', 'EvriNid', 'arachnode.net', 'CamontSpider', 
     'wikiwix-bot', 'Nymesis', 'trendictionbot', 'Sitedomain-Bot', 'SEODat', 'SygolBot', 'Snapbot', 'OpenCalaisSemanticProxy', 'ZookaBot', 
     'CligooRobot', 'cityreview', 'nworm', 'AboutUsBot', 'ICC-Crawler', 'SBIder', 'TwengaBot', 'Dot TK - spider', 'EuripBot', 'ParchBot', 
     'Peew', 'AntBot', 'YRSpider', 'Urlfilebot (Urlbot)', 'Gaisbot', 'WatchMouse', 'Tagoobot', 'Motoricerca-Robots.txt-Checker', 
     'WebWatch/Robot_txtChecker', 'urlfan-bot', 'StatoolsBot', 'page_verifier', 'SSLBot', 'SAI Crawler', 'DomainDB', 'LinkWalker', 
     'WMCAI_robot', 'voyager', 'copyright sheriff', 'Ocelli', 'Twiceler', 'amibot', 'abby', 'NetResearchServer', 'VideoSurf_bot', 
     'XML Sitemaps Generator', 'BlinkaCrawler', 'nodestackbot', 'Pompos', 'taptubot', 'BabalooSpider', 'Yaanb', 'Girafabot', 
     'livedoor ScreenShot', 'eCairn-Grabber', 'FauBot', 'Toread-Crawler', 'Setoozbot ', 'MetaURI', 'L.webis', 'Web-sniffer', 'FairShare', 
     'Ruky-Roboter', 'ThumbShots-Bot', 'BotOnParade', 'Amagit.COM', 'HatenaScreenshot', 'HolmesBot', 'dotSemantic', 'Karneval-Bot', 
     'HostTracker.com', 'AportWorm', 'XmarksFetch', 'FeedFinder/bloggz.se', 'CorpusCrawler', 'Willow Internet Crawler', 'OrgbyBot', 
     'GingerCrawler', 'pingdom.com_bot', 'Nutch', 'baypup', 'Linguee Bot', 'Mp3Bot', '192.comAgent', 'Surphace Scout', 'WikioFeedBot', 
     'Szukacz', 'DBLBot', 'Thumbnail.CZ robot', 'LinguaBot', 'GurujiBot', 'Charlotte', '50.nu', 'SanszBot', 'moba-crawler', 
     'HeartRails_Capture', 'SurveyBot', 'MnoGoSearch', 'smart.apnoti.com Robot', 'Topicbot', 'JadynAveBot', 'OsObot', 'WebImages', 
     'WinWebBot', 'Scooter', 'Scarlett', 'GOFORITBOT', 'DKIMRepBot', 'Yanga', 'DNS-Digger-Explorer', 'Robozilla', 'adidxbot', 'YowedoBot', 
     'botmobi', 'Fooooo_Web_Video_Crawl', 'UptimeDog', '^Nail', 'Metaspinner/0.01', 'Touche', 'RSSMicro.com RSS/Atom Feed Robot', 
     'SniffRSS', 'Kalooga', 'FeedCatBot', 'WebRankSpider', 'Flatland Industries Web Spider', 'DealGates Bot', 'Link Valet Online', 
     'Shelob', 'Technoratibot', 'Flocke bot', 'FollowSite Bot', 'Visbot');
    
    foreach( $bot_list as $bot ) {
      if( stripos($this->getUserAgent(),$bot) !== false ) {
	$this->setRobot(true);
	$this->setMobile(false);
      }
    }
  }

  
  /**
   * Is the browser an ipad.
   * @return boolean True if the browser is from an ipad.
   */
  public function is_iPad()
  {
    return ( $this->getBrowser() == Browser::BROWSER_IPAD );
  }


  protected function checkBrowsers()
  {
    parent::checkBrowsers();

    // now add detection for more bots.
    if( !$this->isRobot() ) $this->bulkCheckRobot();
  }
} // end of class

#
# EOF
#
?>