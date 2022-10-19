<?php

namespace Drupal\consent_manager;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class ConsentManager.
 */
class CodeManager {

  /**
   * Automatic code markup.
   */
  protected const AUTOMATIC_CODE = '<script type="text/javascript" data-cmp-ab="1" src="https://cdn.consentmanager.mgr.consensu.org/delivery/automatic.min.js" data-cmp-id="@cmp_id" data-cmp-host="consentmanager.mgr.consensu.org" data-cmp-cdn="cdn.consentmanager.mgr.consensu.org"></script>';

  /**
   * Semi-automatic code markup.
   */
  protected const SEMI_AUTOMATIC_CODE = '<link rel="stylesheet" href="https://cdn.consentmanager.mgr.consensu.org/delivery/cmp.min.css" /><script>window.gdprAppliesGlobally=true;if(!("cmp_id" in window)){window.cmp_id=@cmp_id}if(!("cmp_params" in window)){window.cmp_params=""}if(!("cmp_host" in window)){window.cmp_host="consentmanager.mgr.consensu.org"}if(!("cmp_cdn" in window)){window.cmp_cdn="cdn.consentmanager.mgr.consensu.org"}window.cmp_getsupportedLangs=function(){var b=["DE","EN","FR","IT","NO","DA","FI","ES","PT","RO","BG","ET","EL","GA","HR","LV","LT","MT","NL","PL","SV","SK","SL","CS","HU","RU","SR","ZH","TR","UK","AR","BS"];if("cmp_customlanguages" in window){for(var a=0;a<window.cmp_customlanguages.length;a++){b.push(window.cmp_customlanguages[a].l.toUpperCase())}}return b};window.cmp_getRTLLangs=function(){return["AR"]};window.cmp_getlang=function(j){if(typeof(j)!="boolean"){j=true}if(j&&typeof(cmp_getlang.usedlang)=="string"&&cmp_getlang.usedlang!==""){return cmp_getlang.usedlang}var g=window.cmp_getsupportedLangs();var c=[];var f=location.hash;var e=location.search;var a="languages" in navigator?navigator.languages:[];if(f.indexOf("cmplang=")!=-1){c.push(f.substr(f.indexOf("cmplang=")+8,2))}else{if(e.indexOf("cmplang=")!=-1){c.push(e.substr(e.indexOf("cmplang=")+8,2))}else{if("cmp_setlang" in window&&window.cmp_setlang!=""){c.push(window.cmp_setlang.toUpperCase())}else{if(a.length>0){for(var d=0;d<a.length;d++){c.push(a[d])}}}}}if("language" in navigator){c.push(navigator.language)}if("userLanguage" in navigator){c.push(navigator.userLanguage)}var h="";for(var d=0;d<c.length;d++){var b=c[d].toUpperCase();if(g.indexOf(b)!=-1){h=b;break}if(b.indexOf("-")!=-1){b=b.substr(0,2)}if(g.indexOf(b)!=-1){h=b;break}}if(h==""&&typeof(cmp_getlang.defaultlang)=="string"&&cmp_getlang.defaultlang!==""){return cmp_getlang.defaultlang}else{if(h==""){h="EN"}}h=h.toUpperCase();return h};(function(){var a="";var f="_en";if("cmp_getlang" in window){a=window.cmp_getlang().toLowerCase();if("cmp_customlanguages" in window){for(var b=0;b<window.cmp_customlanguages.length;b++){if(window.cmp_customlanguages[b].l.toUpperCase()==a.toUpperCase()){a="en";break}}}f="_"+a}var d=("cmp_proto" in window)?window.cmp_proto:"https:";var h=("cmp_ref" in window)?window.cmp_ref:location.href;var c=document.createElement("script");c.setAttribute("data-cmp-ab","1");c.src=d+"//"+window.cmp_host+"/delivery/cmp.php?id="+window.cmp_id+"&h="+encodeURIComponent(h)+"&"+window.cmp_params+(document.cookie.length>0?"&__cmpfcc=1":"")+"&l="+a.toLowerCase()+"&o="+(new Date()).getTime();c.type="text/javascript";c.async=true;if(document.currentScript&&document.currentScript!==null){document.currentScript.parentElement.appendChild(c)}else{if(document.body&&document.body!==null){document.body.appendChild(c)}else{var g=document.getElementsByTagName("body");if(g.length==0){g=document.getElementsByTagName("div")}if(g.length==0){g=document.getElementsByTagName("span")}if(g.length==0){g=document.getElementsByTagName("ins")}if(g.length==0){g=document.getElementsByTagName("script")}if(g.length==0){g=document.getElementsByTagName("head")}if(g.length>0){g[0].appendChild(c)}}}var c=document.createElement("script");c.src=d+"//"+window.cmp_cdn+"/delivery/cmp"+f+".min.js";c.type="text/javascript";c.setAttribute("data-cmp-ab","1");c.async=true;if(document.currentScript&&document.currentScript!==null){document.currentScript.parentElement.appendChild(c)}else{if(document.body&&document.body!==null){document.body.appendChild(c)}else{var g=document.getElementsByTagName("body");if(g.length==0){g=document.getElementsByTagName("div")}if(g.length==0){g=document.getElementsByTagName("span")}if(g.length==0){g=document.getElementsByTagName("ins")}if(g.length==0){g=document.getElementsByTagName("script")}if(g.length==0){g=document.getElementsByTagName("head")}if(g.length>0){g[0].appendChild(c)}}}})();window.cmp_addFrame=function(b){if(!window.frames[b]){if(document.body&&document.body!==null){var a=document.createElement("iframe");a.style.cssText="display:none";a.name=b;document.body.appendChild(a)}else{window.setTimeout(\'window.cmp_addFrame("\'+b+\'")\',10)}}};window.cmp_rc=function(h){var b=document.cookie;var f="";var d=0;while(b!=""&&d<100){d++;while(b.substr(0,1)==" "){b=b.substr(1,b.length)}var g=b.substring(0,b.indexOf("="));if(b.indexOf(";")!=-1){var c=b.substring(b.indexOf("=")+1,b.indexOf(";"))}else{var c=b.substr(b.indexOf("=")+1,b.length)}if(h==g){f=c}var e=b.indexOf(";")+1;if(e==0){e=b.length}b=b.substring(e,b.length)}return(f)};window.cmp_stub=function(){var a=arguments;__cmapi.a=__cmapi.a||[];if(!a.length){return __cmapi.a}else{if(a[0]==="ping"){if(a[1]===2){a[2]({gdprApplies:gdprAppliesGlobally,cmpLoaded:false,cmpStatus:"stub",displayStatus:"hidden",apiVersion:"2.0",cmpId:31},true)}else{a[2]({gdprAppliesGlobally:gdprAppliesGlobally,cmpLoaded:false},true)}}else{if(a[0]==="getUSPData"){a[2]({version:1,uspString:window.cmp_rc("")},true)}else{if(a[0]==="getTCData"){__cmapi.a.push([].slice.apply(a))}else{if(a[0]==="addEventListener"||a[0]==="removeEventListener"){__cmapi.a.push([].slice.apply(a))}else{if(a.length==4&&a[3]===false){a[2]({},false)}else{__cmapi.a.push([].slice.apply(a))}}}}}}};window.cmp_msghandler=function(d){var a=typeof d.data==="string";try{var c=a?JSON.parse(d.data):d.data}catch(f){var c=null}if(typeof(c)==="object"&&c!==null&&"__cmpCall" in c){var b=c.__cmpCall;window.__cmp(b.command,b.parameter,function(h,g){var e={__cmpReturn:{returnValue:h,success:g,callId:b.callId}};d.source.postMessage(a?JSON.stringify(e):e,"*")})}if(typeof(c)==="object"&&c!==null&&"__cmapiCall" in c){var b=c.__cmapiCall;window.__cmapi(b.command,b.parameter,function(h,g){var e={__cmapiReturn:{returnValue:h,success:g,callId:b.callId}};d.source.postMessage(a?JSON.stringify(e):e,"*")})}if(typeof(c)==="object"&&c!==null&&"__uspapiCall" in c){var b=c.__uspapiCall;window.__uspapi(b.command,b.version,function(h,g){var e={__uspapiReturn:{returnValue:h,success:g,callId:b.callId}};d.source.postMessage(a?JSON.stringify(e):e,"*")})}if(typeof(c)==="object"&&c!==null&&"__tcfapiCall" in c){var b=c.__tcfapiCall;window.__tcfapi(b.command,b.version,function(h,g){var e={__tcfapiReturn:{returnValue:h,success:g,callId:b.callId}};d.source.postMessage(a?JSON.stringify(e):e,"*")},b.parameter)}};window.cmp_setStub=function(a){if(!(a in window)||(typeof(window[a])!=="function"&&typeof(window[a])!=="object"&&(typeof(window[a])==="undefined"||window[a]!==null))){window[a]=window.cmp_stub;window[a].msgHandler=window.cmp_msghandler;if(window.addEventListener){window.addEventListener("message",window.cmp_msghandler,false)}else{window.attachEvent("onmessage",window.cmp_msghandler)}}};window.cmp_addFrame("__cmapiLocator");window.cmp_addFrame("__cmpLocator");window.cmp_addFrame("__uspapiLocator");window.cmp_addFrame("__tcfapiLocator");window.cmp_setStub("__cmapi");window.cmp_setStub("__cmp");window.cmp_setStub("__tcfapi");window.cmp_setStub("__uspapi");</script>';

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new ConsentManager object.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Get Consent Manager code.
   *
   * @return \Drupal\Component\Render\FormattableMarkup|false
   *   Code markup or FALSE.
   */
  public function getCode() {
    $config = $this->configFactory->get('consent_manager.settings');

    switch ($config->get('blocking_mode')) {
      case 'automatic':
        $code = $this->getAutomaticCode((int) $config->get('cmp_id'), $config->get('custom_code'));
        break;

      case 'semi_automatic':
        $code = $this->getSemiAutomaticCode((int) $config->get('cmp_id'), $config->get('custom_code'));
        break;

      default:
        $code = FALSE;
    }

    return $code;
  }

  /**
   * Get Consent Manager automatic code markup.
   *
   * @param int $cmp_id
   *   CMP ID value.
   * @param string $custom_code
   *   Custom code.
   *
   * @return \Drupal\Component\Render\FormattableMarkup|false
   *   Code markup or FALSE.
   */
  protected function getAutomaticCode($cmp_id, $custom_code) {
    if (!empty($cmp_id)) {
      $code = trim($custom_code) . self::AUTOMATIC_CODE;
      return new FormattableMarkup($code, ['@cmp_id' => $cmp_id]);
    }
    return FALSE;
  }

  /**
   * Get Consent Manager semi-automatic code markup.
   *
   * @param int $cmp_id
   *   CMP ID value.
   * @param string $custom_code
   *   Custom code.
   *
   * @return \Drupal\Component\Render\FormattableMarkup|false
   *   Code markup or FALSE.
   */
  protected function getSemiAutomaticCode($cmp_id, $custom_code) {
    if (!empty($cmp_id)) {
      $code = trim($custom_code) . self::SEMI_AUTOMATIC_CODE;
      return new FormattableMarkup($code, ['@cmp_id' => $cmp_id]);
    }
    return FALSE;
  }

}
