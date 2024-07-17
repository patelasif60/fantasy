/*! jQuery v3.3.1 | (c) JS Foundation and other contributors | jquery.org/license */
!function(e,t){"use strict";"object"==typeof module&&"object"==typeof module.exports?module.exports=e.document?t(e,!0):function(e){if(!e.document)throw new Error("jQuery requires a window with a document");return t(e)}:t(e)}("undefined"!=typeof window?window:this,function(e,t){"use strict";var n=[],r=e.document,i=Object.getPrototypeOf,o=n.slice,a=n.concat,s=n.push,u=n.indexOf,l={},c=l.toString,f=l.hasOwnProperty,p=f.toString,d=p.call(Object),h={},g=function e(t){return"function"==typeof t&&"number"!=typeof t.nodeType},y=function e(t){return null!=t&&t===t.window},v={type:!0,src:!0,noModule:!0};function m(e,t,n){var i,o=(t=t||r).createElement("script");if(o.text=e,n)for(i in v)n[i]&&(o[i]=n[i]);t.head.appendChild(o).parentNode.removeChild(o)}function x(e){return null==e?e+"":"object"==typeof e||"function"==typeof e?l[c.call(e)]||"object":typeof e}var b="3.3.1",w=function(e,t){return new w.fn.init(e,t)},T=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;w.fn=w.prototype={jquery:"3.3.1",constructor:w,length:0,toArray:function(){return o.call(this)},get:function(e){return null==e?o.call(this):e<0?this[e+this.length]:this[e]},pushStack:function(e){var t=w.merge(this.constructor(),e);return t.prevObject=this,t},each:function(e){return w.each(this,e)},map:function(e){return this.pushStack(w.map(this,function(t,n){return e.call(t,n,t)}))},slice:function(){return this.pushStack(o.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},eq:function(e){var t=this.length,n=+e+(e<0?t:0);return this.pushStack(n>=0&&n<t?[this[n]]:[])},end:function(){return this.prevObject||this.constructor()},push:s,sort:n.sort,splice:n.splice},w.extend=w.fn.extend=function(){var e,t,n,r,i,o,a=arguments[0]||{},s=1,u=arguments.length,l=!1;for("boolean"==typeof a&&(l=a,a=arguments[s]||{},s++),"object"==typeof a||g(a)||(a={}),s===u&&(a=this,s--);s<u;s++)if(null!=(e=arguments[s]))for(t in e)n=a[t],a!==(r=e[t])&&(l&&r&&(w.isPlainObject(r)||(i=Array.isArray(r)))?(i?(i=!1,o=n&&Array.isArray(n)?n:[]):o=n&&w.isPlainObject(n)?n:{},a[t]=w.extend(l,o,r)):void 0!==r&&(a[t]=r));return a},w.extend({expando:"jQuery"+("3.3.1"+Math.random()).replace(/\D/g,""),isReady:!0,error:function(e){throw new Error(e)},noop:function(){},isPlainObject:function(e){var t,n;return!(!e||"[object Object]"!==c.call(e))&&(!(t=i(e))||"function"==typeof(n=f.call(t,"constructor")&&t.constructor)&&p.call(n)===d)},isEmptyObject:function(e){var t;for(t in e)return!1;return!0},globalEval:function(e){m(e)},each:function(e,t){var n,r=0;if(C(e)){for(n=e.length;r<n;r++)if(!1===t.call(e[r],r,e[r]))break}else for(r in e)if(!1===t.call(e[r],r,e[r]))break;return e},trim:function(e){return null==e?"":(e+"").replace(T,"")},makeArray:function(e,t){var n=t||[];return null!=e&&(C(Object(e))?w.merge(n,"string"==typeof e?[e]:e):s.call(n,e)),n},inArray:function(e,t,n){return null==t?-1:u.call(t,e,n)},merge:function(e,t){for(var n=+t.length,r=0,i=e.length;r<n;r++)e[i++]=t[r];return e.length=i,e},grep:function(e,t,n){for(var r,i=[],o=0,a=e.length,s=!n;o<a;o++)(r=!t(e[o],o))!==s&&i.push(e[o]);return i},map:function(e,t,n){var r,i,o=0,s=[];if(C(e))for(r=e.length;o<r;o++)null!=(i=t(e[o],o,n))&&s.push(i);else for(o in e)null!=(i=t(e[o],o,n))&&s.push(i);return a.apply([],s)},guid:1,support:h}),"function"==typeof Symbol&&(w.fn[Symbol.iterator]=n[Symbol.iterator]),w.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "),function(e,t){l["[object "+t+"]"]=t.toLowerCase()});function C(e){var t=!!e&&"length"in e&&e.length,n=x(e);return!g(e)&&!y(e)&&("array"===n||0===t||"number"==typeof t&&t>0&&t-1 in e)}var E=function(e){var t,n,r,i,o,a,s,u,l,c,f,p,d,h,g,y,v,m,x,b="sizzle"+1*new Date,w=e.document,T=0,C=0,E=ae(),k=ae(),S=ae(),D=function(e,t){return e===t&&(f=!0),0},N={}.hasOwnProperty,A=[],j=A.pop,q=A.push,L=A.push,H=A.slice,O=function(e,t){for(var n=0,r=e.length;n<r;n++)if(e[n]===t)return n;return-1},P="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",M="[\\x20\\t\\r\\n\\f]",R="(?:\\\\.|[\\w-]|[^\0-\\xa0])+",I="\\["+M+"*("+R+")(?:"+M+"*([*^$|!~]?=)"+M+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+R+"))|)"+M+"*\\]",W=":("+R+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+I+")*)|.*)\\)|)",$=new RegExp(M+"+","g"),B=new RegExp("^"+M+"+|((?:^|[^\\\\])(?:\\\\.)*)"+M+"+$","g"),F=new RegExp("^"+M+"*,"+M+"*"),_=new RegExp("^"+M+"*([>+~]|"+M+")"+M+"*"),z=new RegExp("="+M+"*([^\\]'\"]*?)"+M+"*\\]","g"),X=new RegExp(W),U=new RegExp("^"+R+"$"),V={ID:new RegExp("^#("+R+")"),CLASS:new RegExp("^\\.("+R+")"),TAG:new RegExp("^("+R+"|[*])"),ATTR:new RegExp("^"+I),PSEUDO:new RegExp("^"+W),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+M+"*(even|odd|(([+-]|)(\\d*)n|)"+M+"*(?:([+-]|)"+M+"*(\\d+)|))"+M+"*\\)|)","i"),bool:new RegExp("^(?:"+P+")$","i"),needsContext:new RegExp("^"+M+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+M+"*((?:-\\d)?\\d*)"+M+"*\\)|)(?=[^-]|$)","i")},G=/^(?:input|select|textarea|button)$/i,Y=/^h\d$/i,Q=/^[^{]+\{\s*\[native \w/,J=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,K=/[+~]/,Z=new RegExp("\\\\([\\da-f]{1,6}"+M+"?|("+M+")|.)","ig"),ee=function(e,t,n){var r="0x"+t-65536;return r!==r||n?t:r<0?String.fromCharCode(r+65536):String.fromCharCode(r>>10|55296,1023&r|56320)},te=/([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,ne=function(e,t){return t?"\0"===e?"\ufffd":e.slice(0,-1)+"\\"+e.charCodeAt(e.length-1).toString(16)+" ":"\\"+e},re=function(){p()},ie=me(function(e){return!0===e.disabled&&("form"in e||"label"in e)},{dir:"parentNode",next:"legend"});try{L.apply(A=H.call(w.childNodes),w.childNodes),A[w.childNodes.length].nodeType}catch(e){L={apply:A.length?function(e,t){q.apply(e,H.call(t))}:function(e,t){var n=e.length,r=0;while(e[n++]=t[r++]);e.length=n-1}}}function oe(e,t,r,i){var o,s,l,c,f,h,v,m=t&&t.ownerDocument,T=t?t.nodeType:9;if(r=r||[],"string"!=typeof e||!e||1!==T&&9!==T&&11!==T)return r;if(!i&&((t?t.ownerDocument||t:w)!==d&&p(t),t=t||d,g)){if(11!==T&&(f=J.exec(e)))if(o=f[1]){if(9===T){if(!(l=t.getElementById(o)))return r;if(l.id===o)return r.push(l),r}else if(m&&(l=m.getElementById(o))&&x(t,l)&&l.id===o)return r.push(l),r}else{if(f[2])return L.apply(r,t.getElementsByTagName(e)),r;if((o=f[3])&&n.getElementsByClassName&&t.getElementsByClassName)return L.apply(r,t.getElementsByClassName(o)),r}if(n.qsa&&!S[e+" "]&&(!y||!y.test(e))){if(1!==T)m=t,v=e;else if("object"!==t.nodeName.toLowerCase()){(c=t.getAttribute("id"))?c=c.replace(te,ne):t.setAttribute("id",c=b),s=(h=a(e)).length;while(s--)h[s]="#"+c+" "+ve(h[s]);v=h.join(","),m=K.test(e)&&ge(t.parentNode)||t}if(v)try{return L.apply(r,m.querySelectorAll(v)),r}catch(e){}finally{c===b&&t.removeAttribute("id")}}}return u(e.replace(B,"$1"),t,r,i)}function ae(){var e=[];function t(n,i){return e.push(n+" ")>r.cacheLength&&delete t[e.shift()],t[n+" "]=i}return t}function se(e){return e[b]=!0,e}function ue(e){var t=d.createElement("fieldset");try{return!!e(t)}catch(e){return!1}finally{t.parentNode&&t.parentNode.removeChild(t),t=null}}function le(e,t){var n=e.split("|"),i=n.length;while(i--)r.attrHandle[n[i]]=t}function ce(e,t){var n=t&&e,r=n&&1===e.nodeType&&1===t.nodeType&&e.sourceIndex-t.sourceIndex;if(r)return r;if(n)while(n=n.nextSibling)if(n===t)return-1;return e?1:-1}function fe(e){return function(t){return"input"===t.nodeName.toLowerCase()&&t.type===e}}function pe(e){return function(t){var n=t.nodeName.toLowerCase();return("input"===n||"button"===n)&&t.type===e}}function de(e){return function(t){return"form"in t?t.parentNode&&!1===t.disabled?"label"in t?"label"in t.parentNode?t.parentNode.disabled===e:t.disabled===e:t.isDisabled===e||t.isDisabled!==!e&&ie(t)===e:t.disabled===e:"label"in t&&t.disabled===e}}function he(e){return se(function(t){return t=+t,se(function(n,r){var i,o=e([],n.length,t),a=o.length;while(a--)n[i=o[a]]&&(n[i]=!(r[i]=n[i]))})})}function ge(e){return e&&"undefined"!=typeof e.getElementsByTagName&&e}n=oe.support={},o=oe.isXML=function(e){var t=e&&(e.ownerDocument||e).documentElement;return!!t&&"HTML"!==t.nodeName},p=oe.setDocument=function(e){var t,i,a=e?e.ownerDocument||e:w;return a!==d&&9===a.nodeType&&a.documentElement?(d=a,h=d.documentElement,g=!o(d),w!==d&&(i=d.defaultView)&&i.top!==i&&(i.addEventListener?i.addEventListener("unload",re,!1):i.attachEvent&&i.attachEvent("onunload",re)),n.attributes=ue(function(e){return e.className="i",!e.getAttribute("className")}),n.getElementsByTagName=ue(function(e){return e.appendChild(d.createComment("")),!e.getElementsByTagName("*").length}),n.getElementsByClassName=Q.test(d.getElementsByClassName),n.getById=ue(function(e){return h.appendChild(e).id=b,!d.getElementsByName||!d.getElementsByName(b).length}),n.getById?(r.filter.ID=function(e){var t=e.replace(Z,ee);return function(e){return e.getAttribute("id")===t}},r.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&g){var n=t.getElementById(e);return n?[n]:[]}}):(r.filter.ID=function(e){var t=e.replace(Z,ee);return function(e){var n="undefined"!=typeof e.getAttributeNode&&e.getAttributeNode("id");return n&&n.value===t}},r.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&g){var n,r,i,o=t.getElementById(e);if(o){if((n=o.getAttributeNode("id"))&&n.value===e)return[o];i=t.getElementsByName(e),r=0;while(o=i[r++])if((n=o.getAttributeNode("id"))&&n.value===e)return[o]}return[]}}),r.find.TAG=n.getElementsByTagName?function(e,t){return"undefined"!=typeof t.getElementsByTagName?t.getElementsByTagName(e):n.qsa?t.querySelectorAll(e):void 0}:function(e,t){var n,r=[],i=0,o=t.getElementsByTagName(e);if("*"===e){while(n=o[i++])1===n.nodeType&&r.push(n);return r}return o},r.find.CLASS=n.getElementsByClassName&&function(e,t){if("undefined"!=typeof t.getElementsByClassName&&g)return t.getElementsByClassName(e)},v=[],y=[],(n.qsa=Q.test(d.querySelectorAll))&&(ue(function(e){h.appendChild(e).innerHTML="<a id='"+b+"'></a><select id='"+b+"-\r\\' msallowcapture=''><option selected=''></option></select>",e.querySelectorAll("[msallowcapture^='']").length&&y.push("[*^$]="+M+"*(?:''|\"\")"),e.querySelectorAll("[selected]").length||y.push("\\["+M+"*(?:value|"+P+")"),e.querySelectorAll("[id~="+b+"-]").length||y.push("~="),e.querySelectorAll(":checked").length||y.push(":checked"),e.querySelectorAll("a#"+b+"+*").length||y.push(".#.+[+~]")}),ue(function(e){e.innerHTML="<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";var t=d.createElement("input");t.setAttribute("type","hidden"),e.appendChild(t).setAttribute("name","D"),e.querySelectorAll("[name=d]").length&&y.push("name"+M+"*[*^$|!~]?="),2!==e.querySelectorAll(":enabled").length&&y.push(":enabled",":disabled"),h.appendChild(e).disabled=!0,2!==e.querySelectorAll(":disabled").length&&y.push(":enabled",":disabled"),e.querySelectorAll("*,:x"),y.push(",.*:")})),(n.matchesSelector=Q.test(m=h.matches||h.webkitMatchesSelector||h.mozMatchesSelector||h.oMatchesSelector||h.msMatchesSelector))&&ue(function(e){n.disconnectedMatch=m.call(e,"*"),m.call(e,"[s!='']:x"),v.push("!=",W)}),y=y.length&&new RegExp(y.join("|")),v=v.length&&new RegExp(v.join("|")),t=Q.test(h.compareDocumentPosition),x=t||Q.test(h.contains)?function(e,t){var n=9===e.nodeType?e.documentElement:e,r=t&&t.parentNode;return e===r||!(!r||1!==r.nodeType||!(n.contains?n.contains(r):e.compareDocumentPosition&&16&e.compareDocumentPosition(r)))}:function(e,t){if(t)while(t=t.parentNode)if(t===e)return!0;return!1},D=t?function(e,t){if(e===t)return f=!0,0;var r=!e.compareDocumentPosition-!t.compareDocumentPosition;return r||(1&(r=(e.ownerDocument||e)===(t.ownerDocument||t)?e.compareDocumentPosition(t):1)||!n.sortDetached&&t.compareDocumentPosition(e)===r?e===d||e.ownerDocument===w&&x(w,e)?-1:t===d||t.ownerDocument===w&&x(w,t)?1:c?O(c,e)-O(c,t):0:4&r?-1:1)}:function(e,t){if(e===t)return f=!0,0;var n,r=0,i=e.parentNode,o=t.parentNode,a=[e],s=[t];if(!i||!o)return e===d?-1:t===d?1:i?-1:o?1:c?O(c,e)-O(c,t):0;if(i===o)return ce(e,t);n=e;while(n=n.parentNode)a.unshift(n);n=t;while(n=n.parentNode)s.unshift(n);while(a[r]===s[r])r++;return r?ce(a[r],s[r]):a[r]===w?-1:s[r]===w?1:0},d):d},oe.matches=function(e,t){return oe(e,null,null,t)},oe.matchesSelector=function(e,t){if((e.ownerDocument||e)!==d&&p(e),t=t.replace(z,"='$1']"),n.matchesSelector&&g&&!S[t+" "]&&(!v||!v.test(t))&&(!y||!y.test(t)))try{var r=m.call(e,t);if(r||n.disconnectedMatch||e.document&&11!==e.document.nodeType)return r}catch(e){}return oe(t,d,null,[e]).length>0},oe.contains=function(e,t){return(e.ownerDocument||e)!==d&&p(e),x(e,t)},oe.attr=function(e,t){(e.ownerDocument||e)!==d&&p(e);var i=r.attrHandle[t.toLowerCase()],o=i&&N.call(r.attrHandle,t.toLowerCase())?i(e,t,!g):void 0;return void 0!==o?o:n.attributes||!g?e.getAttribute(t):(o=e.getAttributeNode(t))&&o.specified?o.value:null},oe.escape=function(e){return(e+"").replace(te,ne)},oe.error=function(e){throw new Error("Syntax error, unrecognized expression: "+e)},oe.uniqueSort=function(e){var t,r=[],i=0,o=0;if(f=!n.detectDuplicates,c=!n.sortStable&&e.slice(0),e.sort(D),f){while(t=e[o++])t===e[o]&&(i=r.push(o));while(i--)e.splice(r[i],1)}return c=null,e},i=oe.getText=function(e){var t,n="",r=0,o=e.nodeType;if(o){if(1===o||9===o||11===o){if("string"==typeof e.textContent)return e.textContent;for(e=e.firstChild;e;e=e.nextSibling)n+=i(e)}else if(3===o||4===o)return e.nodeValue}else while(t=e[r++])n+=i(t);return n},(r=oe.selectors={cacheLength:50,createPseudo:se,match:V,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(e){return e[1]=e[1].replace(Z,ee),e[3]=(e[3]||e[4]||e[5]||"").replace(Z,ee),"~="===e[2]&&(e[3]=" "+e[3]+" "),e.slice(0,4)},CHILD:function(e){return e[1]=e[1].toLowerCase(),"nth"===e[1].slice(0,3)?(e[3]||oe.error(e[0]),e[4]=+(e[4]?e[5]+(e[6]||1):2*("even"===e[3]||"odd"===e[3])),e[5]=+(e[7]+e[8]||"odd"===e[3])):e[3]&&oe.error(e[0]),e},PSEUDO:function(e){var t,n=!e[6]&&e[2];return V.CHILD.test(e[0])?null:(e[3]?e[2]=e[4]||e[5]||"":n&&X.test(n)&&(t=a(n,!0))&&(t=n.indexOf(")",n.length-t)-n.length)&&(e[0]=e[0].slice(0,t),e[2]=n.slice(0,t)),e.slice(0,3))}},filter:{TAG:function(e){var t=e.replace(Z,ee).toLowerCase();return"*"===e?function(){return!0}:function(e){return e.nodeName&&e.nodeName.toLowerCase()===t}},CLASS:function(e){var t=E[e+" "];return t||(t=new RegExp("(^|"+M+")"+e+"("+M+"|$)"))&&E(e,function(e){return t.test("string"==typeof e.className&&e.className||"undefined"!=typeof e.getAttribute&&e.getAttribute("class")||"")})},ATTR:function(e,t,n){return function(r){var i=oe.attr(r,e);return null==i?"!="===t:!t||(i+="","="===t?i===n:"!="===t?i!==n:"^="===t?n&&0===i.indexOf(n):"*="===t?n&&i.indexOf(n)>-1:"$="===t?n&&i.slice(-n.length)===n:"~="===t?(" "+i.replace($," ")+" ").indexOf(n)>-1:"|="===t&&(i===n||i.slice(0,n.length+1)===n+"-"))}},CHILD:function(e,t,n,r,i){var o="nth"!==e.slice(0,3),a="last"!==e.slice(-4),s="of-type"===t;return 1===r&&0===i?function(e){return!!e.parentNode}:function(t,n,u){var l,c,f,p,d,h,g=o!==a?"nextSibling":"previousSibling",y=t.parentNode,v=s&&t.nodeName.toLowerCase(),m=!u&&!s,x=!1;if(y){if(o){while(g){p=t;while(p=p[g])if(s?p.nodeName.toLowerCase()===v:1===p.nodeType)return!1;h=g="only"===e&&!h&&"nextSibling"}return!0}if(h=[a?y.firstChild:y.lastChild],a&&m){x=(d=(l=(c=(f=(p=y)[b]||(p[b]={}))[p.uniqueID]||(f[p.uniqueID]={}))[e]||[])[0]===T&&l[1])&&l[2],p=d&&y.childNodes[d];while(p=++d&&p&&p[g]||(x=d=0)||h.pop())if(1===p.nodeType&&++x&&p===t){c[e]=[T,d,x];break}}else if(m&&(x=d=(l=(c=(f=(p=t)[b]||(p[b]={}))[p.uniqueID]||(f[p.uniqueID]={}))[e]||[])[0]===T&&l[1]),!1===x)while(p=++d&&p&&p[g]||(x=d=0)||h.pop())if((s?p.nodeName.toLowerCase()===v:1===p.nodeType)&&++x&&(m&&((c=(f=p[b]||(p[b]={}))[p.uniqueID]||(f[p.uniqueID]={}))[e]=[T,x]),p===t))break;return(x-=i)===r||x%r==0&&x/r>=0}}},PSEUDO:function(e,t){var n,i=r.pseudos[e]||r.setFilters[e.toLowerCase()]||oe.error("unsupported pseudo: "+e);return i[b]?i(t):i.length>1?(n=[e,e,"",t],r.setFilters.hasOwnProperty(e.toLowerCase())?se(function(e,n){var r,o=i(e,t),a=o.length;while(a--)e[r=O(e,o[a])]=!(n[r]=o[a])}):function(e){return i(e,0,n)}):i}},pseudos:{not:se(function(e){var t=[],n=[],r=s(e.replace(B,"$1"));return r[b]?se(function(e,t,n,i){var o,a=r(e,null,i,[]),s=e.length;while(s--)(o=a[s])&&(e[s]=!(t[s]=o))}):function(e,i,o){return t[0]=e,r(t,null,o,n),t[0]=null,!n.pop()}}),has:se(function(e){return function(t){return oe(e,t).length>0}}),contains:se(function(e){return e=e.replace(Z,ee),function(t){return(t.textContent||t.innerText||i(t)).indexOf(e)>-1}}),lang:se(function(e){return U.test(e||"")||oe.error("unsupported lang: "+e),e=e.replace(Z,ee).toLowerCase(),function(t){var n;do{if(n=g?t.lang:t.getAttribute("xml:lang")||t.getAttribute("lang"))return(n=n.toLowerCase())===e||0===n.indexOf(e+"-")}while((t=t.parentNode)&&1===t.nodeType);return!1}}),target:function(t){var n=e.location&&e.location.hash;return n&&n.slice(1)===t.id},root:function(e){return e===h},focus:function(e){return e===d.activeElement&&(!d.hasFocus||d.hasFocus())&&!!(e.type||e.href||~e.tabIndex)},enabled:de(!1),disabled:de(!0),checked:function(e){var t=e.nodeName.toLowerCase();return"input"===t&&!!e.checked||"option"===t&&!!e.selected},selected:function(e){return e.parentNode&&e.parentNode.selectedIndex,!0===e.selected},empty:function(e){for(e=e.firstChild;e;e=e.nextSibling)if(e.nodeType<6)return!1;return!0},parent:function(e){return!r.pseudos.empty(e)},header:function(e){return Y.test(e.nodeName)},input:function(e){return G.test(e.nodeName)},button:function(e){var t=e.nodeName.toLowerCase();return"input"===t&&"button"===e.type||"button"===t},text:function(e){var t;return"input"===e.nodeName.toLowerCase()&&"text"===e.type&&(null==(t=e.getAttribute("type"))||"text"===t.toLowerCase())},first:he(function(){return[0]}),last:he(function(e,t){return[t-1]}),eq:he(function(e,t,n){return[n<0?n+t:n]}),even:he(function(e,t){for(var n=0;n<t;n+=2)e.push(n);return e}),odd:he(function(e,t){for(var n=1;n<t;n+=2)e.push(n);return e}),lt:he(function(e,t,n){for(var r=n<0?n+t:n;--r>=0;)e.push(r);return e}),gt:he(function(e,t,n){for(var r=n<0?n+t:n;++r<t;)e.push(r);return e})}}).pseudos.nth=r.pseudos.eq;for(t in{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})r.pseudos[t]=fe(t);for(t in{submit:!0,reset:!0})r.pseudos[t]=pe(t);function ye(){}ye.prototype=r.filters=r.pseudos,r.setFilters=new ye,a=oe.tokenize=function(e,t){var n,i,o,a,s,u,l,c=k[e+" "];if(c)return t?0:c.slice(0);s=e,u=[],l=r.preFilter;while(s){n&&!(i=F.exec(s))||(i&&(s=s.slice(i[0].length)||s),u.push(o=[])),n=!1,(i=_.exec(s))&&(n=i.shift(),o.push({value:n,type:i[0].replace(B," ")}),s=s.slice(n.length));for(a in r.filter)!(i=V[a].exec(s))||l[a]&&!(i=l[a](i))||(n=i.shift(),o.push({value:n,type:a,matches:i}),s=s.slice(n.length));if(!n)break}return t?s.length:s?oe.error(e):k(e,u).slice(0)};function ve(e){for(var t=0,n=e.length,r="";t<n;t++)r+=e[t].value;return r}function me(e,t,n){var r=t.dir,i=t.next,o=i||r,a=n&&"parentNode"===o,s=C++;return t.first?function(t,n,i){while(t=t[r])if(1===t.nodeType||a)return e(t,n,i);return!1}:function(t,n,u){var l,c,f,p=[T,s];if(u){while(t=t[r])if((1===t.nodeType||a)&&e(t,n,u))return!0}else while(t=t[r])if(1===t.nodeType||a)if(f=t[b]||(t[b]={}),c=f[t.uniqueID]||(f[t.uniqueID]={}),i&&i===t.nodeName.toLowerCase())t=t[r]||t;else{if((l=c[o])&&l[0]===T&&l[1]===s)return p[2]=l[2];if(c[o]=p,p[2]=e(t,n,u))return!0}return!1}}function xe(e){return e.length>1?function(t,n,r){var i=e.length;while(i--)if(!e[i](t,n,r))return!1;return!0}:e[0]}function be(e,t,n){for(var r=0,i=t.length;r<i;r++)oe(e,t[r],n);return n}function we(e,t,n,r,i){for(var o,a=[],s=0,u=e.length,l=null!=t;s<u;s++)(o=e[s])&&(n&&!n(o,r,i)||(a.push(o),l&&t.push(s)));return a}function Te(e,t,n,r,i,o){return r&&!r[b]&&(r=Te(r)),i&&!i[b]&&(i=Te(i,o)),se(function(o,a,s,u){var l,c,f,p=[],d=[],h=a.length,g=o||be(t||"*",s.nodeType?[s]:s,[]),y=!e||!o&&t?g:we(g,p,e,s,u),v=n?i||(o?e:h||r)?[]:a:y;if(n&&n(y,v,s,u),r){l=we(v,d),r(l,[],s,u),c=l.length;while(c--)(f=l[c])&&(v[d[c]]=!(y[d[c]]=f))}if(o){if(i||e){if(i){l=[],c=v.length;while(c--)(f=v[c])&&l.push(y[c]=f);i(null,v=[],l,u)}c=v.length;while(c--)(f=v[c])&&(l=i?O(o,f):p[c])>-1&&(o[l]=!(a[l]=f))}}else v=we(v===a?v.splice(h,v.length):v),i?i(null,a,v,u):L.apply(a,v)})}function Ce(e){for(var t,n,i,o=e.length,a=r.relative[e[0].type],s=a||r.relative[" "],u=a?1:0,c=me(function(e){return e===t},s,!0),f=me(function(e){return O(t,e)>-1},s,!0),p=[function(e,n,r){var i=!a&&(r||n!==l)||((t=n).nodeType?c(e,n,r):f(e,n,r));return t=null,i}];u<o;u++)if(n=r.relative[e[u].type])p=[me(xe(p),n)];else{if((n=r.filter[e[u].type].apply(null,e[u].matches))[b]){for(i=++u;i<o;i++)if(r.relative[e[i].type])break;return Te(u>1&&xe(p),u>1&&ve(e.slice(0,u-1).concat({value:" "===e[u-2].type?"*":""})).replace(B,"$1"),n,u<i&&Ce(e.slice(u,i)),i<o&&Ce(e=e.slice(i)),i<o&&ve(e))}p.push(n)}return xe(p)}function Ee(e,t){var n=t.length>0,i=e.length>0,o=function(o,a,s,u,c){var f,h,y,v=0,m="0",x=o&&[],b=[],w=l,C=o||i&&r.find.TAG("*",c),E=T+=null==w?1:Math.random()||.1,k=C.length;for(c&&(l=a===d||a||c);m!==k&&null!=(f=C[m]);m++){if(i&&f){h=0,a||f.ownerDocument===d||(p(f),s=!g);while(y=e[h++])if(y(f,a||d,s)){u.push(f);break}c&&(T=E)}n&&((f=!y&&f)&&v--,o&&x.push(f))}if(v+=m,n&&m!==v){h=0;while(y=t[h++])y(x,b,a,s);if(o){if(v>0)while(m--)x[m]||b[m]||(b[m]=j.call(u));b=we(b)}L.apply(u,b),c&&!o&&b.length>0&&v+t.length>1&&oe.uniqueSort(u)}return c&&(T=E,l=w),x};return n?se(o):o}return s=oe.compile=function(e,t){var n,r=[],i=[],o=S[e+" "];if(!o){t||(t=a(e)),n=t.length;while(n--)(o=Ce(t[n]))[b]?r.push(o):i.push(o);(o=S(e,Ee(i,r))).selector=e}return o},u=oe.select=function(e,t,n,i){var o,u,l,c,f,p="function"==typeof e&&e,d=!i&&a(e=p.selector||e);if(n=n||[],1===d.length){if((u=d[0]=d[0].slice(0)).length>2&&"ID"===(l=u[0]).type&&9===t.nodeType&&g&&r.relative[u[1].type]){if(!(t=(r.find.ID(l.matches[0].replace(Z,ee),t)||[])[0]))return n;p&&(t=t.parentNode),e=e.slice(u.shift().value.length)}o=V.needsContext.test(e)?0:u.length;while(o--){if(l=u[o],r.relative[c=l.type])break;if((f=r.find[c])&&(i=f(l.matches[0].replace(Z,ee),K.test(u[0].type)&&ge(t.parentNode)||t))){if(u.splice(o,1),!(e=i.length&&ve(u)))return L.apply(n,i),n;break}}}return(p||s(e,d))(i,t,!g,n,!t||K.test(e)&&ge(t.parentNode)||t),n},n.sortStable=b.split("").sort(D).join("")===b,n.detectDuplicates=!!f,p(),n.sortDetached=ue(function(e){return 1&e.compareDocumentPosition(d.createElement("fieldset"))}),ue(function(e){return e.innerHTML="<a href='#'></a>","#"===e.firstChild.getAttribute("href")})||le("type|href|height|width",function(e,t,n){if(!n)return e.getAttribute(t,"type"===t.toLowerCase()?1:2)}),n.attributes&&ue(function(e){return e.innerHTML="<input/>",e.firstChild.setAttribute("value",""),""===e.firstChild.getAttribute("value")})||le("value",function(e,t,n){if(!n&&"input"===e.nodeName.toLowerCase())return e.defaultValue}),ue(function(e){return null==e.getAttribute("disabled")})||le(P,function(e,t,n){var r;if(!n)return!0===e[t]?t.toLowerCase():(r=e.getAttributeNode(t))&&r.specified?r.value:null}),oe}(e);w.find=E,w.expr=E.selectors,w.expr[":"]=w.expr.pseudos,w.uniqueSort=w.unique=E.uniqueSort,w.text=E.getText,w.isXMLDoc=E.isXML,w.contains=E.contains,w.escapeSelector=E.escape;var k=function(e,t,n){var r=[],i=void 0!==n;while((e=e[t])&&9!==e.nodeType)if(1===e.nodeType){if(i&&w(e).is(n))break;r.push(e)}return r},S=function(e,t){for(var n=[];e;e=e.nextSibling)1===e.nodeType&&e!==t&&n.push(e);return n},D=w.expr.match.needsContext;function N(e,t){return e.nodeName&&e.nodeName.toLowerCase()===t.toLowerCase()}var A=/^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;function j(e,t,n){return g(t)?w.grep(e,function(e,r){return!!t.call(e,r,e)!==n}):t.nodeType?w.grep(e,function(e){return e===t!==n}):"string"!=typeof t?w.grep(e,function(e){return u.call(t,e)>-1!==n}):w.filter(t,e,n)}w.filter=function(e,t,n){var r=t[0];return n&&(e=":not("+e+")"),1===t.length&&1===r.nodeType?w.find.matchesSelector(r,e)?[r]:[]:w.find.matches(e,w.grep(t,function(e){return 1===e.nodeType}))},w.fn.extend({find:function(e){var t,n,r=this.length,i=this;if("string"!=typeof e)return this.pushStack(w(e).filter(function(){for(t=0;t<r;t++)if(w.contains(i[t],this))return!0}));for(n=this.pushStack([]),t=0;t<r;t++)w.find(e,i[t],n);return r>1?w.uniqueSort(n):n},filter:function(e){return this.pushStack(j(this,e||[],!1))},not:function(e){return this.pushStack(j(this,e||[],!0))},is:function(e){return!!j(this,"string"==typeof e&&D.test(e)?w(e):e||[],!1).length}});var q,L=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;(w.fn.init=function(e,t,n){var i,o;if(!e)return this;if(n=n||q,"string"==typeof e){if(!(i="<"===e[0]&&">"===e[e.length-1]&&e.length>=3?[null,e,null]:L.exec(e))||!i[1]&&t)return!t||t.jquery?(t||n).find(e):this.constructor(t).find(e);if(i[1]){if(t=t instanceof w?t[0]:t,w.merge(this,w.parseHTML(i[1],t&&t.nodeType?t.ownerDocument||t:r,!0)),A.test(i[1])&&w.isPlainObject(t))for(i in t)g(this[i])?this[i](t[i]):this.attr(i,t[i]);return this}return(o=r.getElementById(i[2]))&&(this[0]=o,this.length=1),this}return e.nodeType?(this[0]=e,this.length=1,this):g(e)?void 0!==n.ready?n.ready(e):e(w):w.makeArray(e,this)}).prototype=w.fn,q=w(r);var H=/^(?:parents|prev(?:Until|All))/,O={children:!0,contents:!0,next:!0,prev:!0};w.fn.extend({has:function(e){var t=w(e,this),n=t.length;return this.filter(function(){for(var e=0;e<n;e++)if(w.contains(this,t[e]))return!0})},closest:function(e,t){var n,r=0,i=this.length,o=[],a="string"!=typeof e&&w(e);if(!D.test(e))for(;r<i;r++)for(n=this[r];n&&n!==t;n=n.parentNode)if(n.nodeType<11&&(a?a.index(n)>-1:1===n.nodeType&&w.find.matchesSelector(n,e))){o.push(n);break}return this.pushStack(o.length>1?w.uniqueSort(o):o)},index:function(e){return e?"string"==typeof e?u.call(w(e),this[0]):u.call(this,e.jquery?e[0]:e):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(e,t){return this.pushStack(w.uniqueSort(w.merge(this.get(),w(e,t))))},addBack:function(e){return this.add(null==e?this.prevObject:this.prevObject.filter(e))}});function P(e,t){while((e=e[t])&&1!==e.nodeType);return e}w.each({parent:function(e){var t=e.parentNode;return t&&11!==t.nodeType?t:null},parents:function(e){return k(e,"parentNode")},parentsUntil:function(e,t,n){return k(e,"parentNode",n)},next:function(e){return P(e,"nextSibling")},prev:function(e){return P(e,"previousSibling")},nextAll:function(e){return k(e,"nextSibling")},prevAll:function(e){return k(e,"previousSibling")},nextUntil:function(e,t,n){return k(e,"nextSibling",n)},prevUntil:function(e,t,n){return k(e,"previousSibling",n)},siblings:function(e){return S((e.parentNode||{}).firstChild,e)},children:function(e){return S(e.firstChild)},contents:function(e){return N(e,"iframe")?e.contentDocument:(N(e,"template")&&(e=e.content||e),w.merge([],e.childNodes))}},function(e,t){w.fn[e]=function(n,r){var i=w.map(this,t,n);return"Until"!==e.slice(-5)&&(r=n),r&&"string"==typeof r&&(i=w.filter(r,i)),this.length>1&&(O[e]||w.uniqueSort(i),H.test(e)&&i.reverse()),this.pushStack(i)}});var M=/[^\x20\t\r\n\f]+/g;function R(e){var t={};return w.each(e.match(M)||[],function(e,n){t[n]=!0}),t}w.Callbacks=function(e){e="string"==typeof e?R(e):w.extend({},e);var t,n,r,i,o=[],a=[],s=-1,u=function(){for(i=i||e.once,r=t=!0;a.length;s=-1){n=a.shift();while(++s<o.length)!1===o[s].apply(n[0],n[1])&&e.stopOnFalse&&(s=o.length,n=!1)}e.memory||(n=!1),t=!1,i&&(o=n?[]:"")},l={add:function(){return o&&(n&&!t&&(s=o.length-1,a.push(n)),function t(n){w.each(n,function(n,r){g(r)?e.unique&&l.has(r)||o.push(r):r&&r.length&&"string"!==x(r)&&t(r)})}(arguments),n&&!t&&u()),this},remove:function(){return w.each(arguments,function(e,t){var n;while((n=w.inArray(t,o,n))>-1)o.splice(n,1),n<=s&&s--}),this},has:function(e){return e?w.inArray(e,o)>-1:o.length>0},empty:function(){return o&&(o=[]),this},disable:function(){return i=a=[],o=n="",this},disabled:function(){return!o},lock:function(){return i=a=[],n||t||(o=n=""),this},locked:function(){return!!i},fireWith:function(e,n){return i||(n=[e,(n=n||[]).slice?n.slice():n],a.push(n),t||u()),this},fire:function(){return l.fireWith(this,arguments),this},fired:function(){return!!r}};return l};function I(e){return e}function W(e){throw e}function $(e,t,n,r){var i;try{e&&g(i=e.promise)?i.call(e).done(t).fail(n):e&&g(i=e.then)?i.call(e,t,n):t.apply(void 0,[e].slice(r))}catch(e){n.apply(void 0,[e])}}w.extend({Deferred:function(t){var n=[["notify","progress",w.Callbacks("memory"),w.Callbacks("memory"),2],["resolve","done",w.Callbacks("once memory"),w.Callbacks("once memory"),0,"resolved"],["reject","fail",w.Callbacks("once memory"),w.Callbacks("once memory"),1,"rejected"]],r="pending",i={state:function(){return r},always:function(){return o.done(arguments).fail(arguments),this},"catch":function(e){return i.then(null,e)},pipe:function(){var e=arguments;return w.Deferred(function(t){w.each(n,function(n,r){var i=g(e[r[4]])&&e[r[4]];o[r[1]](function(){var e=i&&i.apply(this,arguments);e&&g(e.promise)?e.promise().progress(t.notify).done(t.resolve).fail(t.reject):t[r[0]+"With"](this,i?[e]:arguments)})}),e=null}).promise()},then:function(t,r,i){var o=0;function a(t,n,r,i){return function(){var s=this,u=arguments,l=function(){var e,l;if(!(t<o)){if((e=r.apply(s,u))===n.promise())throw new TypeError("Thenable self-resolution");l=e&&("object"==typeof e||"function"==typeof e)&&e.then,g(l)?i?l.call(e,a(o,n,I,i),a(o,n,W,i)):(o++,l.call(e,a(o,n,I,i),a(o,n,W,i),a(o,n,I,n.notifyWith))):(r!==I&&(s=void 0,u=[e]),(i||n.resolveWith)(s,u))}},c=i?l:function(){try{l()}catch(e){w.Deferred.exceptionHook&&w.Deferred.exceptionHook(e,c.stackTrace),t+1>=o&&(r!==W&&(s=void 0,u=[e]),n.rejectWith(s,u))}};t?c():(w.Deferred.getStackHook&&(c.stackTrace=w.Deferred.getStackHook()),e.setTimeout(c))}}return w.Deferred(function(e){n[0][3].add(a(0,e,g(i)?i:I,e.notifyWith)),n[1][3].add(a(0,e,g(t)?t:I)),n[2][3].add(a(0,e,g(r)?r:W))}).promise()},promise:function(e){return null!=e?w.extend(e,i):i}},o={};return w.each(n,function(e,t){var a=t[2],s=t[5];i[t[1]]=a.add,s&&a.add(function(){r=s},n[3-e][2].disable,n[3-e][3].disable,n[0][2].lock,n[0][3].lock),a.add(t[3].fire),o[t[0]]=function(){return o[t[0]+"With"](this===o?void 0:this,arguments),this},o[t[0]+"With"]=a.fireWith}),i.promise(o),t&&t.call(o,o),o},when:function(e){var t=arguments.length,n=t,r=Array(n),i=o.call(arguments),a=w.Deferred(),s=function(e){return function(n){r[e]=this,i[e]=arguments.length>1?o.call(arguments):n,--t||a.resolveWith(r,i)}};if(t<=1&&($(e,a.done(s(n)).resolve,a.reject,!t),"pending"===a.state()||g(i[n]&&i[n].then)))return a.then();while(n--)$(i[n],s(n),a.reject);return a.promise()}});var B=/^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;w.Deferred.exceptionHook=function(t,n){e.console&&e.console.warn&&t&&B.test(t.name)&&e.console.warn("jQuery.Deferred exception: "+t.message,t.stack,n)},w.readyException=function(t){e.setTimeout(function(){throw t})};var F=w.Deferred();w.fn.ready=function(e){return F.then(e)["catch"](function(e){w.readyException(e)}),this},w.extend({isReady:!1,readyWait:1,ready:function(e){(!0===e?--w.readyWait:w.isReady)||(w.isReady=!0,!0!==e&&--w.readyWait>0||F.resolveWith(r,[w]))}}),w.ready.then=F.then;function _(){r.removeEventListener("DOMContentLoaded",_),e.removeEventListener("load",_),w.ready()}"complete"===r.readyState||"loading"!==r.readyState&&!r.documentElement.doScroll?e.setTimeout(w.ready):(r.addEventListener("DOMContentLoaded",_),e.addEventListener("load",_));var z=function(e,t,n,r,i,o,a){var s=0,u=e.length,l=null==n;if("object"===x(n)){i=!0;for(s in n)z(e,t,s,n[s],!0,o,a)}else if(void 0!==r&&(i=!0,g(r)||(a=!0),l&&(a?(t.call(e,r),t=null):(l=t,t=function(e,t,n){return l.call(w(e),n)})),t))for(;s<u;s++)t(e[s],n,a?r:r.call(e[s],s,t(e[s],n)));return i?e:l?t.call(e):u?t(e[0],n):o},X=/^-ms-/,U=/-([a-z])/g;function V(e,t){return t.toUpperCase()}function G(e){return e.replace(X,"ms-").replace(U,V)}var Y=function(e){return 1===e.nodeType||9===e.nodeType||!+e.nodeType};function Q(){this.expando=w.expando+Q.uid++}Q.uid=1,Q.prototype={cache:function(e){var t=e[this.expando];return t||(t={},Y(e)&&(e.nodeType?e[this.expando]=t:Object.defineProperty(e,this.expando,{value:t,configurable:!0}))),t},set:function(e,t,n){var r,i=this.cache(e);if("string"==typeof t)i[G(t)]=n;else for(r in t)i[G(r)]=t[r];return i},get:function(e,t){return void 0===t?this.cache(e):e[this.expando]&&e[this.expando][G(t)]},access:function(e,t,n){return void 0===t||t&&"string"==typeof t&&void 0===n?this.get(e,t):(this.set(e,t,n),void 0!==n?n:t)},remove:function(e,t){var n,r=e[this.expando];if(void 0!==r){if(void 0!==t){n=(t=Array.isArray(t)?t.map(G):(t=G(t))in r?[t]:t.match(M)||[]).length;while(n--)delete r[t[n]]}(void 0===t||w.isEmptyObject(r))&&(e.nodeType?e[this.expando]=void 0:delete e[this.expando])}},hasData:function(e){var t=e[this.expando];return void 0!==t&&!w.isEmptyObject(t)}};var J=new Q,K=new Q,Z=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,ee=/[A-Z]/g;function te(e){return"true"===e||"false"!==e&&("null"===e?null:e===+e+""?+e:Z.test(e)?JSON.parse(e):e)}function ne(e,t,n){var r;if(void 0===n&&1===e.nodeType)if(r="data-"+t.replace(ee,"-$&").toLowerCase(),"string"==typeof(n=e.getAttribute(r))){try{n=te(n)}catch(e){}K.set(e,t,n)}else n=void 0;return n}w.extend({hasData:function(e){return K.hasData(e)||J.hasData(e)},data:function(e,t,n){return K.access(e,t,n)},removeData:function(e,t){K.remove(e,t)},_data:function(e,t,n){return J.access(e,t,n)},_removeData:function(e,t){J.remove(e,t)}}),w.fn.extend({data:function(e,t){var n,r,i,o=this[0],a=o&&o.attributes;if(void 0===e){if(this.length&&(i=K.get(o),1===o.nodeType&&!J.get(o,"hasDataAttrs"))){n=a.length;while(n--)a[n]&&0===(r=a[n].name).indexOf("data-")&&(r=G(r.slice(5)),ne(o,r,i[r]));J.set(o,"hasDataAttrs",!0)}return i}return"object"==typeof e?this.each(function(){K.set(this,e)}):z(this,function(t){var n;if(o&&void 0===t){if(void 0!==(n=K.get(o,e)))return n;if(void 0!==(n=ne(o,e)))return n}else this.each(function(){K.set(this,e,t)})},null,t,arguments.length>1,null,!0)},removeData:function(e){return this.each(function(){K.remove(this,e)})}}),w.extend({queue:function(e,t,n){var r;if(e)return t=(t||"fx")+"queue",r=J.get(e,t),n&&(!r||Array.isArray(n)?r=J.access(e,t,w.makeArray(n)):r.push(n)),r||[]},dequeue:function(e,t){t=t||"fx";var n=w.queue(e,t),r=n.length,i=n.shift(),o=w._queueHooks(e,t),a=function(){w.dequeue(e,t)};"inprogress"===i&&(i=n.shift(),r--),i&&("fx"===t&&n.unshift("inprogress"),delete o.stop,i.call(e,a,o)),!r&&o&&o.empty.fire()},_queueHooks:function(e,t){var n=t+"queueHooks";return J.get(e,n)||J.access(e,n,{empty:w.Callbacks("once memory").add(function(){J.remove(e,[t+"queue",n])})})}}),w.fn.extend({queue:function(e,t){var n=2;return"string"!=typeof e&&(t=e,e="fx",n--),arguments.length<n?w.queue(this[0],e):void 0===t?this:this.each(function(){var n=w.queue(this,e,t);w._queueHooks(this,e),"fx"===e&&"inprogress"!==n[0]&&w.dequeue(this,e)})},dequeue:function(e){return this.each(function(){w.dequeue(this,e)})},clearQueue:function(e){return this.queue(e||"fx",[])},promise:function(e,t){var n,r=1,i=w.Deferred(),o=this,a=this.length,s=function(){--r||i.resolveWith(o,[o])};"string"!=typeof e&&(t=e,e=void 0),e=e||"fx";while(a--)(n=J.get(o[a],e+"queueHooks"))&&n.empty&&(r++,n.empty.add(s));return s(),i.promise(t)}});var re=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,ie=new RegExp("^(?:([+-])=|)("+re+")([a-z%]*)$","i"),oe=["Top","Right","Bottom","Left"],ae=function(e,t){return"none"===(e=t||e).style.display||""===e.style.display&&w.contains(e.ownerDocument,e)&&"none"===w.css(e,"display")},se=function(e,t,n,r){var i,o,a={};for(o in t)a[o]=e.style[o],e.style[o]=t[o];i=n.apply(e,r||[]);for(o in t)e.style[o]=a[o];return i};function ue(e,t,n,r){var i,o,a=20,s=r?function(){return r.cur()}:function(){return w.css(e,t,"")},u=s(),l=n&&n[3]||(w.cssNumber[t]?"":"px"),c=(w.cssNumber[t]||"px"!==l&&+u)&&ie.exec(w.css(e,t));if(c&&c[3]!==l){u/=2,l=l||c[3],c=+u||1;while(a--)w.style(e,t,c+l),(1-o)*(1-(o=s()/u||.5))<=0&&(a=0),c/=o;c*=2,w.style(e,t,c+l),n=n||[]}return n&&(c=+c||+u||0,i=n[1]?c+(n[1]+1)*n[2]:+n[2],r&&(r.unit=l,r.start=c,r.end=i)),i}var le={};function ce(e){var t,n=e.ownerDocument,r=e.nodeName,i=le[r];return i||(t=n.body.appendChild(n.createElement(r)),i=w.css(t,"display"),t.parentNode.removeChild(t),"none"===i&&(i="block"),le[r]=i,i)}function fe(e,t){for(var n,r,i=[],o=0,a=e.length;o<a;o++)(r=e[o]).style&&(n=r.style.display,t?("none"===n&&(i[o]=J.get(r,"display")||null,i[o]||(r.style.display="")),""===r.style.display&&ae(r)&&(i[o]=ce(r))):"none"!==n&&(i[o]="none",J.set(r,"display",n)));for(o=0;o<a;o++)null!=i[o]&&(e[o].style.display=i[o]);return e}w.fn.extend({show:function(){return fe(this,!0)},hide:function(){return fe(this)},toggle:function(e){return"boolean"==typeof e?e?this.show():this.hide():this.each(function(){ae(this)?w(this).show():w(this).hide()})}});var pe=/^(?:checkbox|radio)$/i,de=/<([a-z][^\/\0>\x20\t\r\n\f]+)/i,he=/^$|^module$|\/(?:java|ecma)script/i,ge={option:[1,"<select multiple='multiple'>","</select>"],thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};ge.optgroup=ge.option,ge.tbody=ge.tfoot=ge.colgroup=ge.caption=ge.thead,ge.th=ge.td;function ye(e,t){var n;return n="undefined"!=typeof e.getElementsByTagName?e.getElementsByTagName(t||"*"):"undefined"!=typeof e.querySelectorAll?e.querySelectorAll(t||"*"):[],void 0===t||t&&N(e,t)?w.merge([e],n):n}function ve(e,t){for(var n=0,r=e.length;n<r;n++)J.set(e[n],"globalEval",!t||J.get(t[n],"globalEval"))}var me=/<|&#?\w+;/;function xe(e,t,n,r,i){for(var o,a,s,u,l,c,f=t.createDocumentFragment(),p=[],d=0,h=e.length;d<h;d++)if((o=e[d])||0===o)if("object"===x(o))w.merge(p,o.nodeType?[o]:o);else if(me.test(o)){a=a||f.appendChild(t.createElement("div")),s=(de.exec(o)||["",""])[1].toLowerCase(),u=ge[s]||ge._default,a.innerHTML=u[1]+w.htmlPrefilter(o)+u[2],c=u[0];while(c--)a=a.lastChild;w.merge(p,a.childNodes),(a=f.firstChild).textContent=""}else p.push(t.createTextNode(o));f.textContent="",d=0;while(o=p[d++])if(r&&w.inArray(o,r)>-1)i&&i.push(o);else if(l=w.contains(o.ownerDocument,o),a=ye(f.appendChild(o),"script"),l&&ve(a),n){c=0;while(o=a[c++])he.test(o.type||"")&&n.push(o)}return f}!function(){var e=r.createDocumentFragment().appendChild(r.createElement("div")),t=r.createElement("input");t.setAttribute("type","radio"),t.setAttribute("checked","checked"),t.setAttribute("name","t"),e.appendChild(t),h.checkClone=e.cloneNode(!0).cloneNode(!0).lastChild.checked,e.innerHTML="<textarea>x</textarea>",h.noCloneChecked=!!e.cloneNode(!0).lastChild.defaultValue}();var be=r.documentElement,we=/^key/,Te=/^(?:mouse|pointer|contextmenu|drag|drop)|click/,Ce=/^([^.]*)(?:\.(.+)|)/;function Ee(){return!0}function ke(){return!1}function Se(){try{return r.activeElement}catch(e){}}function De(e,t,n,r,i,o){var a,s;if("object"==typeof t){"string"!=typeof n&&(r=r||n,n=void 0);for(s in t)De(e,s,n,r,t[s],o);return e}if(null==r&&null==i?(i=n,r=n=void 0):null==i&&("string"==typeof n?(i=r,r=void 0):(i=r,r=n,n=void 0)),!1===i)i=ke;else if(!i)return e;return 1===o&&(a=i,(i=function(e){return w().off(e),a.apply(this,arguments)}).guid=a.guid||(a.guid=w.guid++)),e.each(function(){w.event.add(this,t,i,r,n)})}w.event={global:{},add:function(e,t,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,y=J.get(e);if(y){n.handler&&(n=(o=n).handler,i=o.selector),i&&w.find.matchesSelector(be,i),n.guid||(n.guid=w.guid++),(u=y.events)||(u=y.events={}),(a=y.handle)||(a=y.handle=function(t){return"undefined"!=typeof w&&w.event.triggered!==t.type?w.event.dispatch.apply(e,arguments):void 0}),l=(t=(t||"").match(M)||[""]).length;while(l--)d=g=(s=Ce.exec(t[l])||[])[1],h=(s[2]||"").split(".").sort(),d&&(f=w.event.special[d]||{},d=(i?f.delegateType:f.bindType)||d,f=w.event.special[d]||{},c=w.extend({type:d,origType:g,data:r,handler:n,guid:n.guid,selector:i,needsContext:i&&w.expr.match.needsContext.test(i),namespace:h.join(".")},o),(p=u[d])||((p=u[d]=[]).delegateCount=0,f.setup&&!1!==f.setup.call(e,r,h,a)||e.addEventListener&&e.addEventListener(d,a)),f.add&&(f.add.call(e,c),c.handler.guid||(c.handler.guid=n.guid)),i?p.splice(p.delegateCount++,0,c):p.push(c),w.event.global[d]=!0)}},remove:function(e,t,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,y=J.hasData(e)&&J.get(e);if(y&&(u=y.events)){l=(t=(t||"").match(M)||[""]).length;while(l--)if(s=Ce.exec(t[l])||[],d=g=s[1],h=(s[2]||"").split(".").sort(),d){f=w.event.special[d]||{},p=u[d=(r?f.delegateType:f.bindType)||d]||[],s=s[2]&&new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"),a=o=p.length;while(o--)c=p[o],!i&&g!==c.origType||n&&n.guid!==c.guid||s&&!s.test(c.namespace)||r&&r!==c.selector&&("**"!==r||!c.selector)||(p.splice(o,1),c.selector&&p.delegateCount--,f.remove&&f.remove.call(e,c));a&&!p.length&&(f.teardown&&!1!==f.teardown.call(e,h,y.handle)||w.removeEvent(e,d,y.handle),delete u[d])}else for(d in u)w.event.remove(e,d+t[l],n,r,!0);w.isEmptyObject(u)&&J.remove(e,"handle events")}},dispatch:function(e){var t=w.event.fix(e),n,r,i,o,a,s,u=new Array(arguments.length),l=(J.get(this,"events")||{})[t.type]||[],c=w.event.special[t.type]||{};for(u[0]=t,n=1;n<arguments.length;n++)u[n]=arguments[n];if(t.delegateTarget=this,!c.preDispatch||!1!==c.preDispatch.call(this,t)){s=w.event.handlers.call(this,t,l),n=0;while((o=s[n++])&&!t.isPropagationStopped()){t.currentTarget=o.elem,r=0;while((a=o.handlers[r++])&&!t.isImmediatePropagationStopped())t.rnamespace&&!t.rnamespace.test(a.namespace)||(t.handleObj=a,t.data=a.data,void 0!==(i=((w.event.special[a.origType]||{}).handle||a.handler).apply(o.elem,u))&&!1===(t.result=i)&&(t.preventDefault(),t.stopPropagation()))}return c.postDispatch&&c.postDispatch.call(this,t),t.result}},handlers:function(e,t){var n,r,i,o,a,s=[],u=t.delegateCount,l=e.target;if(u&&l.nodeType&&!("click"===e.type&&e.button>=1))for(;l!==this;l=l.parentNode||this)if(1===l.nodeType&&("click"!==e.type||!0!==l.disabled)){for(o=[],a={},n=0;n<u;n++)void 0===a[i=(r=t[n]).selector+" "]&&(a[i]=r.needsContext?w(i,this).index(l)>-1:w.find(i,this,null,[l]).length),a[i]&&o.push(r);o.length&&s.push({elem:l,handlers:o})}return l=this,u<t.length&&s.push({elem:l,handlers:t.slice(u)}),s},addProp:function(e,t){Object.defineProperty(w.Event.prototype,e,{enumerable:!0,configurable:!0,get:g(t)?function(){if(this.originalEvent)return t(this.originalEvent)}:function(){if(this.originalEvent)return this.originalEvent[e]},set:function(t){Object.defineProperty(this,e,{enumerable:!0,configurable:!0,writable:!0,value:t})}})},fix:function(e){return e[w.expando]?e:new w.Event(e)},special:{load:{noBubble:!0},focus:{trigger:function(){if(this!==Se()&&this.focus)return this.focus(),!1},delegateType:"focusin"},blur:{trigger:function(){if(this===Se()&&this.blur)return this.blur(),!1},delegateType:"focusout"},click:{trigger:function(){if("checkbox"===this.type&&this.click&&N(this,"input"))return this.click(),!1},_default:function(e){return N(e.target,"a")}},beforeunload:{postDispatch:function(e){void 0!==e.result&&e.originalEvent&&(e.originalEvent.returnValue=e.result)}}}},w.removeEvent=function(e,t,n){e.removeEventListener&&e.removeEventListener(t,n)},w.Event=function(e,t){if(!(this instanceof w.Event))return new w.Event(e,t);e&&e.type?(this.originalEvent=e,this.type=e.type,this.isDefaultPrevented=e.defaultPrevented||void 0===e.defaultPrevented&&!1===e.returnValue?Ee:ke,this.target=e.target&&3===e.target.nodeType?e.target.parentNode:e.target,this.currentTarget=e.currentTarget,this.relatedTarget=e.relatedTarget):this.type=e,t&&w.extend(this,t),this.timeStamp=e&&e.timeStamp||Date.now(),this[w.expando]=!0},w.Event.prototype={constructor:w.Event,isDefaultPrevented:ke,isPropagationStopped:ke,isImmediatePropagationStopped:ke,isSimulated:!1,preventDefault:function(){var e=this.originalEvent;this.isDefaultPrevented=Ee,e&&!this.isSimulated&&e.preventDefault()},stopPropagation:function(){var e=this.originalEvent;this.isPropagationStopped=Ee,e&&!this.isSimulated&&e.stopPropagation()},stopImmediatePropagation:function(){var e=this.originalEvent;this.isImmediatePropagationStopped=Ee,e&&!this.isSimulated&&e.stopImmediatePropagation(),this.stopPropagation()}},w.each({altKey:!0,bubbles:!0,cancelable:!0,changedTouches:!0,ctrlKey:!0,detail:!0,eventPhase:!0,metaKey:!0,pageX:!0,pageY:!0,shiftKey:!0,view:!0,"char":!0,charCode:!0,key:!0,keyCode:!0,button:!0,buttons:!0,clientX:!0,clientY:!0,offsetX:!0,offsetY:!0,pointerId:!0,pointerType:!0,screenX:!0,screenY:!0,targetTouches:!0,toElement:!0,touches:!0,which:function(e){var t=e.button;return null==e.which&&we.test(e.type)?null!=e.charCode?e.charCode:e.keyCode:!e.which&&void 0!==t&&Te.test(e.type)?1&t?1:2&t?3:4&t?2:0:e.which}},w.event.addProp),w.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(e,t){w.event.special[e]={delegateType:t,bindType:t,handle:function(e){var n,r=this,i=e.relatedTarget,o=e.handleObj;return i&&(i===r||w.contains(r,i))||(e.type=o.origType,n=o.handler.apply(this,arguments),e.type=t),n}}}),w.fn.extend({on:function(e,t,n,r){return De(this,e,t,n,r)},one:function(e,t,n,r){return De(this,e,t,n,r,1)},off:function(e,t,n){var r,i;if(e&&e.preventDefault&&e.handleObj)return r=e.handleObj,w(e.delegateTarget).off(r.namespace?r.origType+"."+r.namespace:r.origType,r.selector,r.handler),this;if("object"==typeof e){for(i in e)this.off(i,t,e[i]);return this}return!1!==t&&"function"!=typeof t||(n=t,t=void 0),!1===n&&(n=ke),this.each(function(){w.event.remove(this,e,n,t)})}});var Ne=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([a-z][^\/\0>\x20\t\r\n\f]*)[^>]*)\/>/gi,Ae=/<script|<style|<link/i,je=/checked\s*(?:[^=]|=\s*.checked.)/i,qe=/^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;function Le(e,t){return N(e,"table")&&N(11!==t.nodeType?t:t.firstChild,"tr")?w(e).children("tbody")[0]||e:e}function He(e){return e.type=(null!==e.getAttribute("type"))+"/"+e.type,e}function Oe(e){return"true/"===(e.type||"").slice(0,5)?e.type=e.type.slice(5):e.removeAttribute("type"),e}function Pe(e,t){var n,r,i,o,a,s,u,l;if(1===t.nodeType){if(J.hasData(e)&&(o=J.access(e),a=J.set(t,o),l=o.events)){delete a.handle,a.events={};for(i in l)for(n=0,r=l[i].length;n<r;n++)w.event.add(t,i,l[i][n])}K.hasData(e)&&(s=K.access(e),u=w.extend({},s),K.set(t,u))}}function Me(e,t){var n=t.nodeName.toLowerCase();"input"===n&&pe.test(e.type)?t.checked=e.checked:"input"!==n&&"textarea"!==n||(t.defaultValue=e.defaultValue)}function Re(e,t,n,r){t=a.apply([],t);var i,o,s,u,l,c,f=0,p=e.length,d=p-1,y=t[0],v=g(y);if(v||p>1&&"string"==typeof y&&!h.checkClone&&je.test(y))return e.each(function(i){var o=e.eq(i);v&&(t[0]=y.call(this,i,o.html())),Re(o,t,n,r)});if(p&&(i=xe(t,e[0].ownerDocument,!1,e,r),o=i.firstChild,1===i.childNodes.length&&(i=o),o||r)){for(u=(s=w.map(ye(i,"script"),He)).length;f<p;f++)l=i,f!==d&&(l=w.clone(l,!0,!0),u&&w.merge(s,ye(l,"script"))),n.call(e[f],l,f);if(u)for(c=s[s.length-1].ownerDocument,w.map(s,Oe),f=0;f<u;f++)l=s[f],he.test(l.type||"")&&!J.access(l,"globalEval")&&w.contains(c,l)&&(l.src&&"module"!==(l.type||"").toLowerCase()?w._evalUrl&&w._evalUrl(l.src):m(l.textContent.replace(qe,""),c,l))}return e}function Ie(e,t,n){for(var r,i=t?w.filter(t,e):e,o=0;null!=(r=i[o]);o++)n||1!==r.nodeType||w.cleanData(ye(r)),r.parentNode&&(n&&w.contains(r.ownerDocument,r)&&ve(ye(r,"script")),r.parentNode.removeChild(r));return e}w.extend({htmlPrefilter:function(e){return e.replace(Ne,"<$1></$2>")},clone:function(e,t,n){var r,i,o,a,s=e.cloneNode(!0),u=w.contains(e.ownerDocument,e);if(!(h.noCloneChecked||1!==e.nodeType&&11!==e.nodeType||w.isXMLDoc(e)))for(a=ye(s),r=0,i=(o=ye(e)).length;r<i;r++)Me(o[r],a[r]);if(t)if(n)for(o=o||ye(e),a=a||ye(s),r=0,i=o.length;r<i;r++)Pe(o[r],a[r]);else Pe(e,s);return(a=ye(s,"script")).length>0&&ve(a,!u&&ye(e,"script")),s},cleanData:function(e){for(var t,n,r,i=w.event.special,o=0;void 0!==(n=e[o]);o++)if(Y(n)){if(t=n[J.expando]){if(t.events)for(r in t.events)i[r]?w.event.remove(n,r):w.removeEvent(n,r,t.handle);n[J.expando]=void 0}n[K.expando]&&(n[K.expando]=void 0)}}}),w.fn.extend({detach:function(e){return Ie(this,e,!0)},remove:function(e){return Ie(this,e)},text:function(e){return z(this,function(e){return void 0===e?w.text(this):this.empty().each(function(){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||(this.textContent=e)})},null,e,arguments.length)},append:function(){return Re(this,arguments,function(e){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||Le(this,e).appendChild(e)})},prepend:function(){return Re(this,arguments,function(e){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var t=Le(this,e);t.insertBefore(e,t.firstChild)}})},before:function(){return Re(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this)})},after:function(){return Re(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this.nextSibling)})},empty:function(){for(var e,t=0;null!=(e=this[t]);t++)1===e.nodeType&&(w.cleanData(ye(e,!1)),e.textContent="");return this},clone:function(e,t){return e=null!=e&&e,t=null==t?e:t,this.map(function(){return w.clone(this,e,t)})},html:function(e){return z(this,function(e){var t=this[0]||{},n=0,r=this.length;if(void 0===e&&1===t.nodeType)return t.innerHTML;if("string"==typeof e&&!Ae.test(e)&&!ge[(de.exec(e)||["",""])[1].toLowerCase()]){e=w.htmlPrefilter(e);try{for(;n<r;n++)1===(t=this[n]||{}).nodeType&&(w.cleanData(ye(t,!1)),t.innerHTML=e);t=0}catch(e){}}t&&this.empty().append(e)},null,e,arguments.length)},replaceWith:function(){var e=[];return Re(this,arguments,function(t){var n=this.parentNode;w.inArray(this,e)<0&&(w.cleanData(ye(this)),n&&n.replaceChild(t,this))},e)}}),w.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(e,t){w.fn[e]=function(e){for(var n,r=[],i=w(e),o=i.length-1,a=0;a<=o;a++)n=a===o?this:this.clone(!0),w(i[a])[t](n),s.apply(r,n.get());return this.pushStack(r)}});var We=new RegExp("^("+re+")(?!px)[a-z%]+$","i"),$e=function(t){var n=t.ownerDocument.defaultView;return n&&n.opener||(n=e),n.getComputedStyle(t)},Be=new RegExp(oe.join("|"),"i");!function(){function t(){if(c){l.style.cssText="position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0",c.style.cssText="position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%",be.appendChild(l).appendChild(c);var t=e.getComputedStyle(c);i="1%"!==t.top,u=12===n(t.marginLeft),c.style.right="60%",s=36===n(t.right),o=36===n(t.width),c.style.position="absolute",a=36===c.offsetWidth||"absolute",be.removeChild(l),c=null}}function n(e){return Math.round(parseFloat(e))}var i,o,a,s,u,l=r.createElement("div"),c=r.createElement("div");c.style&&(c.style.backgroundClip="content-box",c.cloneNode(!0).style.backgroundClip="",h.clearCloneStyle="content-box"===c.style.backgroundClip,w.extend(h,{boxSizingReliable:function(){return t(),o},pixelBoxStyles:function(){return t(),s},pixelPosition:function(){return t(),i},reliableMarginLeft:function(){return t(),u},scrollboxSize:function(){return t(),a}}))}();function Fe(e,t,n){var r,i,o,a,s=e.style;return(n=n||$e(e))&&(""!==(a=n.getPropertyValue(t)||n[t])||w.contains(e.ownerDocument,e)||(a=w.style(e,t)),!h.pixelBoxStyles()&&We.test(a)&&Be.test(t)&&(r=s.width,i=s.minWidth,o=s.maxWidth,s.minWidth=s.maxWidth=s.width=a,a=n.width,s.width=r,s.minWidth=i,s.maxWidth=o)),void 0!==a?a+"":a}function _e(e,t){return{get:function(){if(!e())return(this.get=t).apply(this,arguments);delete this.get}}}var ze=/^(none|table(?!-c[ea]).+)/,Xe=/^--/,Ue={position:"absolute",visibility:"hidden",display:"block"},Ve={letterSpacing:"0",fontWeight:"400"},Ge=["Webkit","Moz","ms"],Ye=r.createElement("div").style;function Qe(e){if(e in Ye)return e;var t=e[0].toUpperCase()+e.slice(1),n=Ge.length;while(n--)if((e=Ge[n]+t)in Ye)return e}function Je(e){var t=w.cssProps[e];return t||(t=w.cssProps[e]=Qe(e)||e),t}function Ke(e,t,n){var r=ie.exec(t);return r?Math.max(0,r[2]-(n||0))+(r[3]||"px"):t}function Ze(e,t,n,r,i,o){var a="width"===t?1:0,s=0,u=0;if(n===(r?"border":"content"))return 0;for(;a<4;a+=2)"margin"===n&&(u+=w.css(e,n+oe[a],!0,i)),r?("content"===n&&(u-=w.css(e,"padding"+oe[a],!0,i)),"margin"!==n&&(u-=w.css(e,"border"+oe[a]+"Width",!0,i))):(u+=w.css(e,"padding"+oe[a],!0,i),"padding"!==n?u+=w.css(e,"border"+oe[a]+"Width",!0,i):s+=w.css(e,"border"+oe[a]+"Width",!0,i));return!r&&o>=0&&(u+=Math.max(0,Math.ceil(e["offset"+t[0].toUpperCase()+t.slice(1)]-o-u-s-.5))),u}function et(e,t,n){var r=$e(e),i=Fe(e,t,r),o="border-box"===w.css(e,"boxSizing",!1,r),a=o;if(We.test(i)){if(!n)return i;i="auto"}return a=a&&(h.boxSizingReliable()||i===e.style[t]),("auto"===i||!parseFloat(i)&&"inline"===w.css(e,"display",!1,r))&&(i=e["offset"+t[0].toUpperCase()+t.slice(1)],a=!0),(i=parseFloat(i)||0)+Ze(e,t,n||(o?"border":"content"),a,r,i)+"px"}w.extend({cssHooks:{opacity:{get:function(e,t){if(t){var n=Fe(e,"opacity");return""===n?"1":n}}}},cssNumber:{animationIterationCount:!0,columnCount:!0,fillOpacity:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{},style:function(e,t,n,r){if(e&&3!==e.nodeType&&8!==e.nodeType&&e.style){var i,o,a,s=G(t),u=Xe.test(t),l=e.style;if(u||(t=Je(s)),a=w.cssHooks[t]||w.cssHooks[s],void 0===n)return a&&"get"in a&&void 0!==(i=a.get(e,!1,r))?i:l[t];"string"==(o=typeof n)&&(i=ie.exec(n))&&i[1]&&(n=ue(e,t,i),o="number"),null!=n&&n===n&&("number"===o&&(n+=i&&i[3]||(w.cssNumber[s]?"":"px")),h.clearCloneStyle||""!==n||0!==t.indexOf("background")||(l[t]="inherit"),a&&"set"in a&&void 0===(n=a.set(e,n,r))||(u?l.setProperty(t,n):l[t]=n))}},css:function(e,t,n,r){var i,o,a,s=G(t);return Xe.test(t)||(t=Je(s)),(a=w.cssHooks[t]||w.cssHooks[s])&&"get"in a&&(i=a.get(e,!0,n)),void 0===i&&(i=Fe(e,t,r)),"normal"===i&&t in Ve&&(i=Ve[t]),""===n||n?(o=parseFloat(i),!0===n||isFinite(o)?o||0:i):i}}),w.each(["height","width"],function(e,t){w.cssHooks[t]={get:function(e,n,r){if(n)return!ze.test(w.css(e,"display"))||e.getClientRects().length&&e.getBoundingClientRect().width?et(e,t,r):se(e,Ue,function(){return et(e,t,r)})},set:function(e,n,r){var i,o=$e(e),a="border-box"===w.css(e,"boxSizing",!1,o),s=r&&Ze(e,t,r,a,o);return a&&h.scrollboxSize()===o.position&&(s-=Math.ceil(e["offset"+t[0].toUpperCase()+t.slice(1)]-parseFloat(o[t])-Ze(e,t,"border",!1,o)-.5)),s&&(i=ie.exec(n))&&"px"!==(i[3]||"px")&&(e.style[t]=n,n=w.css(e,t)),Ke(e,n,s)}}}),w.cssHooks.marginLeft=_e(h.reliableMarginLeft,function(e,t){if(t)return(parseFloat(Fe(e,"marginLeft"))||e.getBoundingClientRect().left-se(e,{marginLeft:0},function(){return e.getBoundingClientRect().left}))+"px"}),w.each({margin:"",padding:"",border:"Width"},function(e,t){w.cssHooks[e+t]={expand:function(n){for(var r=0,i={},o="string"==typeof n?n.split(" "):[n];r<4;r++)i[e+oe[r]+t]=o[r]||o[r-2]||o[0];return i}},"margin"!==e&&(w.cssHooks[e+t].set=Ke)}),w.fn.extend({css:function(e,t){return z(this,function(e,t,n){var r,i,o={},a=0;if(Array.isArray(t)){for(r=$e(e),i=t.length;a<i;a++)o[t[a]]=w.css(e,t[a],!1,r);return o}return void 0!==n?w.style(e,t,n):w.css(e,t)},e,t,arguments.length>1)}});function tt(e,t,n,r,i){return new tt.prototype.init(e,t,n,r,i)}w.Tween=tt,tt.prototype={constructor:tt,init:function(e,t,n,r,i,o){this.elem=e,this.prop=n,this.easing=i||w.easing._default,this.options=t,this.start=this.now=this.cur(),this.end=r,this.unit=o||(w.cssNumber[n]?"":"px")},cur:function(){var e=tt.propHooks[this.prop];return e&&e.get?e.get(this):tt.propHooks._default.get(this)},run:function(e){var t,n=tt.propHooks[this.prop];return this.options.duration?this.pos=t=w.easing[this.easing](e,this.options.duration*e,0,1,this.options.duration):this.pos=t=e,this.now=(this.end-this.start)*t+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),n&&n.set?n.set(this):tt.propHooks._default.set(this),this}},tt.prototype.init.prototype=tt.prototype,tt.propHooks={_default:{get:function(e){var t;return 1!==e.elem.nodeType||null!=e.elem[e.prop]&&null==e.elem.style[e.prop]?e.elem[e.prop]:(t=w.css(e.elem,e.prop,""))&&"auto"!==t?t:0},set:function(e){w.fx.step[e.prop]?w.fx.step[e.prop](e):1!==e.elem.nodeType||null==e.elem.style[w.cssProps[e.prop]]&&!w.cssHooks[e.prop]?e.elem[e.prop]=e.now:w.style(e.elem,e.prop,e.now+e.unit)}}},tt.propHooks.scrollTop=tt.propHooks.scrollLeft={set:function(e){e.elem.nodeType&&e.elem.parentNode&&(e.elem[e.prop]=e.now)}},w.easing={linear:function(e){return e},swing:function(e){return.5-Math.cos(e*Math.PI)/2},_default:"swing"},w.fx=tt.prototype.init,w.fx.step={};var nt,rt,it=/^(?:toggle|show|hide)$/,ot=/queueHooks$/;function at(){rt&&(!1===r.hidden&&e.requestAnimationFrame?e.requestAnimationFrame(at):e.setTimeout(at,w.fx.interval),w.fx.tick())}function st(){return e.setTimeout(function(){nt=void 0}),nt=Date.now()}function ut(e,t){var n,r=0,i={height:e};for(t=t?1:0;r<4;r+=2-t)i["margin"+(n=oe[r])]=i["padding"+n]=e;return t&&(i.opacity=i.width=e),i}function lt(e,t,n){for(var r,i=(pt.tweeners[t]||[]).concat(pt.tweeners["*"]),o=0,a=i.length;o<a;o++)if(r=i[o].call(n,t,e))return r}function ct(e,t,n){var r,i,o,a,s,u,l,c,f="width"in t||"height"in t,p=this,d={},h=e.style,g=e.nodeType&&ae(e),y=J.get(e,"fxshow");n.queue||(null==(a=w._queueHooks(e,"fx")).unqueued&&(a.unqueued=0,s=a.empty.fire,a.empty.fire=function(){a.unqueued||s()}),a.unqueued++,p.always(function(){p.always(function(){a.unqueued--,w.queue(e,"fx").length||a.empty.fire()})}));for(r in t)if(i=t[r],it.test(i)){if(delete t[r],o=o||"toggle"===i,i===(g?"hide":"show")){if("show"!==i||!y||void 0===y[r])continue;g=!0}d[r]=y&&y[r]||w.style(e,r)}if((u=!w.isEmptyObject(t))||!w.isEmptyObject(d)){f&&1===e.nodeType&&(n.overflow=[h.overflow,h.overflowX,h.overflowY],null==(l=y&&y.display)&&(l=J.get(e,"display")),"none"===(c=w.css(e,"display"))&&(l?c=l:(fe([e],!0),l=e.style.display||l,c=w.css(e,"display"),fe([e]))),("inline"===c||"inline-block"===c&&null!=l)&&"none"===w.css(e,"float")&&(u||(p.done(function(){h.display=l}),null==l&&(c=h.display,l="none"===c?"":c)),h.display="inline-block")),n.overflow&&(h.overflow="hidden",p.always(function(){h.overflow=n.overflow[0],h.overflowX=n.overflow[1],h.overflowY=n.overflow[2]})),u=!1;for(r in d)u||(y?"hidden"in y&&(g=y.hidden):y=J.access(e,"fxshow",{display:l}),o&&(y.hidden=!g),g&&fe([e],!0),p.done(function(){g||fe([e]),J.remove(e,"fxshow");for(r in d)w.style(e,r,d[r])})),u=lt(g?y[r]:0,r,p),r in y||(y[r]=u.start,g&&(u.end=u.start,u.start=0))}}function ft(e,t){var n,r,i,o,a;for(n in e)if(r=G(n),i=t[r],o=e[n],Array.isArray(o)&&(i=o[1],o=e[n]=o[0]),n!==r&&(e[r]=o,delete e[n]),(a=w.cssHooks[r])&&"expand"in a){o=a.expand(o),delete e[r];for(n in o)n in e||(e[n]=o[n],t[n]=i)}else t[r]=i}function pt(e,t,n){var r,i,o=0,a=pt.prefilters.length,s=w.Deferred().always(function(){delete u.elem}),u=function(){if(i)return!1;for(var t=nt||st(),n=Math.max(0,l.startTime+l.duration-t),r=1-(n/l.duration||0),o=0,a=l.tweens.length;o<a;o++)l.tweens[o].run(r);return s.notifyWith(e,[l,r,n]),r<1&&a?n:(a||s.notifyWith(e,[l,1,0]),s.resolveWith(e,[l]),!1)},l=s.promise({elem:e,props:w.extend({},t),opts:w.extend(!0,{specialEasing:{},easing:w.easing._default},n),originalProperties:t,originalOptions:n,startTime:nt||st(),duration:n.duration,tweens:[],createTween:function(t,n){var r=w.Tween(e,l.opts,t,n,l.opts.specialEasing[t]||l.opts.easing);return l.tweens.push(r),r},stop:function(t){var n=0,r=t?l.tweens.length:0;if(i)return this;for(i=!0;n<r;n++)l.tweens[n].run(1);return t?(s.notifyWith(e,[l,1,0]),s.resolveWith(e,[l,t])):s.rejectWith(e,[l,t]),this}}),c=l.props;for(ft(c,l.opts.specialEasing);o<a;o++)if(r=pt.prefilters[o].call(l,e,c,l.opts))return g(r.stop)&&(w._queueHooks(l.elem,l.opts.queue).stop=r.stop.bind(r)),r;return w.map(c,lt,l),g(l.opts.start)&&l.opts.start.call(e,l),l.progress(l.opts.progress).done(l.opts.done,l.opts.complete).fail(l.opts.fail).always(l.opts.always),w.fx.timer(w.extend(u,{elem:e,anim:l,queue:l.opts.queue})),l}w.Animation=w.extend(pt,{tweeners:{"*":[function(e,t){var n=this.createTween(e,t);return ue(n.elem,e,ie.exec(t),n),n}]},tweener:function(e,t){g(e)?(t=e,e=["*"]):e=e.match(M);for(var n,r=0,i=e.length;r<i;r++)n=e[r],pt.tweeners[n]=pt.tweeners[n]||[],pt.tweeners[n].unshift(t)},prefilters:[ct],prefilter:function(e,t){t?pt.prefilters.unshift(e):pt.prefilters.push(e)}}),w.speed=function(e,t,n){var r=e&&"object"==typeof e?w.extend({},e):{complete:n||!n&&t||g(e)&&e,duration:e,easing:n&&t||t&&!g(t)&&t};return w.fx.off?r.duration=0:"number"!=typeof r.duration&&(r.duration in w.fx.speeds?r.duration=w.fx.speeds[r.duration]:r.duration=w.fx.speeds._default),null!=r.queue&&!0!==r.queue||(r.queue="fx"),r.old=r.complete,r.complete=function(){g(r.old)&&r.old.call(this),r.queue&&w.dequeue(this,r.queue)},r},w.fn.extend({fadeTo:function(e,t,n,r){return this.filter(ae).css("opacity",0).show().end().animate({opacity:t},e,n,r)},animate:function(e,t,n,r){var i=w.isEmptyObject(e),o=w.speed(t,n,r),a=function(){var t=pt(this,w.extend({},e),o);(i||J.get(this,"finish"))&&t.stop(!0)};return a.finish=a,i||!1===o.queue?this.each(a):this.queue(o.queue,a)},stop:function(e,t,n){var r=function(e){var t=e.stop;delete e.stop,t(n)};return"string"!=typeof e&&(n=t,t=e,e=void 0),t&&!1!==e&&this.queue(e||"fx",[]),this.each(function(){var t=!0,i=null!=e&&e+"queueHooks",o=w.timers,a=J.get(this);if(i)a[i]&&a[i].stop&&r(a[i]);else for(i in a)a[i]&&a[i].stop&&ot.test(i)&&r(a[i]);for(i=o.length;i--;)o[i].elem!==this||null!=e&&o[i].queue!==e||(o[i].anim.stop(n),t=!1,o.splice(i,1));!t&&n||w.dequeue(this,e)})},finish:function(e){return!1!==e&&(e=e||"fx"),this.each(function(){var t,n=J.get(this),r=n[e+"queue"],i=n[e+"queueHooks"],o=w.timers,a=r?r.length:0;for(n.finish=!0,w.queue(this,e,[]),i&&i.stop&&i.stop.call(this,!0),t=o.length;t--;)o[t].elem===this&&o[t].queue===e&&(o[t].anim.stop(!0),o.splice(t,1));for(t=0;t<a;t++)r[t]&&r[t].finish&&r[t].finish.call(this);delete n.finish})}}),w.each(["toggle","show","hide"],function(e,t){var n=w.fn[t];w.fn[t]=function(e,r,i){return null==e||"boolean"==typeof e?n.apply(this,arguments):this.animate(ut(t,!0),e,r,i)}}),w.each({slideDown:ut("show"),slideUp:ut("hide"),slideToggle:ut("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(e,t){w.fn[e]=function(e,n,r){return this.animate(t,e,n,r)}}),w.timers=[],w.fx.tick=function(){var e,t=0,n=w.timers;for(nt=Date.now();t<n.length;t++)(e=n[t])()||n[t]!==e||n.splice(t--,1);n.length||w.fx.stop(),nt=void 0},w.fx.timer=function(e){w.timers.push(e),w.fx.start()},w.fx.interval=13,w.fx.start=function(){rt||(rt=!0,at())},w.fx.stop=function(){rt=null},w.fx.speeds={slow:600,fast:200,_default:400},w.fn.delay=function(t,n){return t=w.fx?w.fx.speeds[t]||t:t,n=n||"fx",this.queue(n,function(n,r){var i=e.setTimeout(n,t);r.stop=function(){e.clearTimeout(i)}})},function(){var e=r.createElement("input"),t=r.createElement("select").appendChild(r.createElement("option"));e.type="checkbox",h.checkOn=""!==e.value,h.optSelected=t.selected,(e=r.createElement("input")).value="t",e.type="radio",h.radioValue="t"===e.value}();var dt,ht=w.expr.attrHandle;w.fn.extend({attr:function(e,t){return z(this,w.attr,e,t,arguments.length>1)},removeAttr:function(e){return this.each(function(){w.removeAttr(this,e)})}}),w.extend({attr:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return"undefined"==typeof e.getAttribute?w.prop(e,t,n):(1===o&&w.isXMLDoc(e)||(i=w.attrHooks[t.toLowerCase()]||(w.expr.match.bool.test(t)?dt:void 0)),void 0!==n?null===n?void w.removeAttr(e,t):i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:(e.setAttribute(t,n+""),n):i&&"get"in i&&null!==(r=i.get(e,t))?r:null==(r=w.find.attr(e,t))?void 0:r)},attrHooks:{type:{set:function(e,t){if(!h.radioValue&&"radio"===t&&N(e,"input")){var n=e.value;return e.setAttribute("type",t),n&&(e.value=n),t}}}},removeAttr:function(e,t){var n,r=0,i=t&&t.match(M);if(i&&1===e.nodeType)while(n=i[r++])e.removeAttribute(n)}}),dt={set:function(e,t,n){return!1===t?w.removeAttr(e,n):e.setAttribute(n,n),n}},w.each(w.expr.match.bool.source.match(/\w+/g),function(e,t){var n=ht[t]||w.find.attr;ht[t]=function(e,t,r){var i,o,a=t.toLowerCase();return r||(o=ht[a],ht[a]=i,i=null!=n(e,t,r)?a:null,ht[a]=o),i}});var gt=/^(?:input|select|textarea|button)$/i,yt=/^(?:a|area)$/i;w.fn.extend({prop:function(e,t){return z(this,w.prop,e,t,arguments.length>1)},removeProp:function(e){return this.each(function(){delete this[w.propFix[e]||e]})}}),w.extend({prop:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return 1===o&&w.isXMLDoc(e)||(t=w.propFix[t]||t,i=w.propHooks[t]),void 0!==n?i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:e[t]=n:i&&"get"in i&&null!==(r=i.get(e,t))?r:e[t]},propHooks:{tabIndex:{get:function(e){var t=w.find.attr(e,"tabindex");return t?parseInt(t,10):gt.test(e.nodeName)||yt.test(e.nodeName)&&e.href?0:-1}}},propFix:{"for":"htmlFor","class":"className"}}),h.optSelected||(w.propHooks.selected={get:function(e){var t=e.parentNode;return t&&t.parentNode&&t.parentNode.selectedIndex,null},set:function(e){var t=e.parentNode;t&&(t.selectedIndex,t.parentNode&&t.parentNode.selectedIndex)}}),w.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){w.propFix[this.toLowerCase()]=this});function vt(e){return(e.match(M)||[]).join(" ")}function mt(e){return e.getAttribute&&e.getAttribute("class")||""}function xt(e){return Array.isArray(e)?e:"string"==typeof e?e.match(M)||[]:[]}w.fn.extend({addClass:function(e){var t,n,r,i,o,a,s,u=0;if(g(e))return this.each(function(t){w(this).addClass(e.call(this,t,mt(this)))});if((t=xt(e)).length)while(n=this[u++])if(i=mt(n),r=1===n.nodeType&&" "+vt(i)+" "){a=0;while(o=t[a++])r.indexOf(" "+o+" ")<0&&(r+=o+" ");i!==(s=vt(r))&&n.setAttribute("class",s)}return this},removeClass:function(e){var t,n,r,i,o,a,s,u=0;if(g(e))return this.each(function(t){w(this).removeClass(e.call(this,t,mt(this)))});if(!arguments.length)return this.attr("class","");if((t=xt(e)).length)while(n=this[u++])if(i=mt(n),r=1===n.nodeType&&" "+vt(i)+" "){a=0;while(o=t[a++])while(r.indexOf(" "+o+" ")>-1)r=r.replace(" "+o+" "," ");i!==(s=vt(r))&&n.setAttribute("class",s)}return this},toggleClass:function(e,t){var n=typeof e,r="string"===n||Array.isArray(e);return"boolean"==typeof t&&r?t?this.addClass(e):this.removeClass(e):g(e)?this.each(function(n){w(this).toggleClass(e.call(this,n,mt(this),t),t)}):this.each(function(){var t,i,o,a;if(r){i=0,o=w(this),a=xt(e);while(t=a[i++])o.hasClass(t)?o.removeClass(t):o.addClass(t)}else void 0!==e&&"boolean"!==n||((t=mt(this))&&J.set(this,"__className__",t),this.setAttribute&&this.setAttribute("class",t||!1===e?"":J.get(this,"__className__")||""))})},hasClass:function(e){var t,n,r=0;t=" "+e+" ";while(n=this[r++])if(1===n.nodeType&&(" "+vt(mt(n))+" ").indexOf(t)>-1)return!0;return!1}});var bt=/\r/g;w.fn.extend({val:function(e){var t,n,r,i=this[0];{if(arguments.length)return r=g(e),this.each(function(n){var i;1===this.nodeType&&(null==(i=r?e.call(this,n,w(this).val()):e)?i="":"number"==typeof i?i+="":Array.isArray(i)&&(i=w.map(i,function(e){return null==e?"":e+""})),(t=w.valHooks[this.type]||w.valHooks[this.nodeName.toLowerCase()])&&"set"in t&&void 0!==t.set(this,i,"value")||(this.value=i))});if(i)return(t=w.valHooks[i.type]||w.valHooks[i.nodeName.toLowerCase()])&&"get"in t&&void 0!==(n=t.get(i,"value"))?n:"string"==typeof(n=i.value)?n.replace(bt,""):null==n?"":n}}}),w.extend({valHooks:{option:{get:function(e){var t=w.find.attr(e,"value");return null!=t?t:vt(w.text(e))}},select:{get:function(e){var t,n,r,i=e.options,o=e.selectedIndex,a="select-one"===e.type,s=a?null:[],u=a?o+1:i.length;for(r=o<0?u:a?o:0;r<u;r++)if(((n=i[r]).selected||r===o)&&!n.disabled&&(!n.parentNode.disabled||!N(n.parentNode,"optgroup"))){if(t=w(n).val(),a)return t;s.push(t)}return s},set:function(e,t){var n,r,i=e.options,o=w.makeArray(t),a=i.length;while(a--)((r=i[a]).selected=w.inArray(w.valHooks.option.get(r),o)>-1)&&(n=!0);return n||(e.selectedIndex=-1),o}}}}),w.each(["radio","checkbox"],function(){w.valHooks[this]={set:function(e,t){if(Array.isArray(t))return e.checked=w.inArray(w(e).val(),t)>-1}},h.checkOn||(w.valHooks[this].get=function(e){return null===e.getAttribute("value")?"on":e.value})}),h.focusin="onfocusin"in e;var wt=/^(?:focusinfocus|focusoutblur)$/,Tt=function(e){e.stopPropagation()};w.extend(w.event,{trigger:function(t,n,i,o){var a,s,u,l,c,p,d,h,v=[i||r],m=f.call(t,"type")?t.type:t,x=f.call(t,"namespace")?t.namespace.split("."):[];if(s=h=u=i=i||r,3!==i.nodeType&&8!==i.nodeType&&!wt.test(m+w.event.triggered)&&(m.indexOf(".")>-1&&(m=(x=m.split(".")).shift(),x.sort()),c=m.indexOf(":")<0&&"on"+m,t=t[w.expando]?t:new w.Event(m,"object"==typeof t&&t),t.isTrigger=o?2:3,t.namespace=x.join("."),t.rnamespace=t.namespace?new RegExp("(^|\\.)"+x.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,t.result=void 0,t.target||(t.target=i),n=null==n?[t]:w.makeArray(n,[t]),d=w.event.special[m]||{},o||!d.trigger||!1!==d.trigger.apply(i,n))){if(!o&&!d.noBubble&&!y(i)){for(l=d.delegateType||m,wt.test(l+m)||(s=s.parentNode);s;s=s.parentNode)v.push(s),u=s;u===(i.ownerDocument||r)&&v.push(u.defaultView||u.parentWindow||e)}a=0;while((s=v[a++])&&!t.isPropagationStopped())h=s,t.type=a>1?l:d.bindType||m,(p=(J.get(s,"events")||{})[t.type]&&J.get(s,"handle"))&&p.apply(s,n),(p=c&&s[c])&&p.apply&&Y(s)&&(t.result=p.apply(s,n),!1===t.result&&t.preventDefault());return t.type=m,o||t.isDefaultPrevented()||d._default&&!1!==d._default.apply(v.pop(),n)||!Y(i)||c&&g(i[m])&&!y(i)&&((u=i[c])&&(i[c]=null),w.event.triggered=m,t.isPropagationStopped()&&h.addEventListener(m,Tt),i[m](),t.isPropagationStopped()&&h.removeEventListener(m,Tt),w.event.triggered=void 0,u&&(i[c]=u)),t.result}},simulate:function(e,t,n){var r=w.extend(new w.Event,n,{type:e,isSimulated:!0});w.event.trigger(r,null,t)}}),w.fn.extend({trigger:function(e,t){return this.each(function(){w.event.trigger(e,t,this)})},triggerHandler:function(e,t){var n=this[0];if(n)return w.event.trigger(e,t,n,!0)}}),h.focusin||w.each({focus:"focusin",blur:"focusout"},function(e,t){var n=function(e){w.event.simulate(t,e.target,w.event.fix(e))};w.event.special[t]={setup:function(){var r=this.ownerDocument||this,i=J.access(r,t);i||r.addEventListener(e,n,!0),J.access(r,t,(i||0)+1)},teardown:function(){var r=this.ownerDocument||this,i=J.access(r,t)-1;i?J.access(r,t,i):(r.removeEventListener(e,n,!0),J.remove(r,t))}}});var Ct=e.location,Et=Date.now(),kt=/\?/;w.parseXML=function(t){var n;if(!t||"string"!=typeof t)return null;try{n=(new e.DOMParser).parseFromString(t,"text/xml")}catch(e){n=void 0}return n&&!n.getElementsByTagName("parsererror").length||w.error("Invalid XML: "+t),n};var St=/\[\]$/,Dt=/\r?\n/g,Nt=/^(?:submit|button|image|reset|file)$/i,At=/^(?:input|select|textarea|keygen)/i;function jt(e,t,n,r){var i;if(Array.isArray(t))w.each(t,function(t,i){n||St.test(e)?r(e,i):jt(e+"["+("object"==typeof i&&null!=i?t:"")+"]",i,n,r)});else if(n||"object"!==x(t))r(e,t);else for(i in t)jt(e+"["+i+"]",t[i],n,r)}w.param=function(e,t){var n,r=[],i=function(e,t){var n=g(t)?t():t;r[r.length]=encodeURIComponent(e)+"="+encodeURIComponent(null==n?"":n)};if(Array.isArray(e)||e.jquery&&!w.isPlainObject(e))w.each(e,function(){i(this.name,this.value)});else for(n in e)jt(n,e[n],t,i);return r.join("&")},w.fn.extend({serialize:function(){return w.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var e=w.prop(this,"elements");return e?w.makeArray(e):this}).filter(function(){var e=this.type;return this.name&&!w(this).is(":disabled")&&At.test(this.nodeName)&&!Nt.test(e)&&(this.checked||!pe.test(e))}).map(function(e,t){var n=w(this).val();return null==n?null:Array.isArray(n)?w.map(n,function(e){return{name:t.name,value:e.replace(Dt,"\r\n")}}):{name:t.name,value:n.replace(Dt,"\r\n")}}).get()}});var qt=/%20/g,Lt=/#.*$/,Ht=/([?&])_=[^&]*/,Ot=/^(.*?):[ \t]*([^\r\n]*)$/gm,Pt=/^(?:about|app|app-storage|.+-extension|file|res|widget):$/,Mt=/^(?:GET|HEAD)$/,Rt=/^\/\//,It={},Wt={},$t="*/".concat("*"),Bt=r.createElement("a");Bt.href=Ct.href;function Ft(e){return function(t,n){"string"!=typeof t&&(n=t,t="*");var r,i=0,o=t.toLowerCase().match(M)||[];if(g(n))while(r=o[i++])"+"===r[0]?(r=r.slice(1)||"*",(e[r]=e[r]||[]).unshift(n)):(e[r]=e[r]||[]).push(n)}}function _t(e,t,n,r){var i={},o=e===Wt;function a(s){var u;return i[s]=!0,w.each(e[s]||[],function(e,s){var l=s(t,n,r);return"string"!=typeof l||o||i[l]?o?!(u=l):void 0:(t.dataTypes.unshift(l),a(l),!1)}),u}return a(t.dataTypes[0])||!i["*"]&&a("*")}function zt(e,t){var n,r,i=w.ajaxSettings.flatOptions||{};for(n in t)void 0!==t[n]&&((i[n]?e:r||(r={}))[n]=t[n]);return r&&w.extend(!0,e,r),e}function Xt(e,t,n){var r,i,o,a,s=e.contents,u=e.dataTypes;while("*"===u[0])u.shift(),void 0===r&&(r=e.mimeType||t.getResponseHeader("Content-Type"));if(r)for(i in s)if(s[i]&&s[i].test(r)){u.unshift(i);break}if(u[0]in n)o=u[0];else{for(i in n){if(!u[0]||e.converters[i+" "+u[0]]){o=i;break}a||(a=i)}o=o||a}if(o)return o!==u[0]&&u.unshift(o),n[o]}function Ut(e,t,n,r){var i,o,a,s,u,l={},c=e.dataTypes.slice();if(c[1])for(a in e.converters)l[a.toLowerCase()]=e.converters[a];o=c.shift();while(o)if(e.responseFields[o]&&(n[e.responseFields[o]]=t),!u&&r&&e.dataFilter&&(t=e.dataFilter(t,e.dataType)),u=o,o=c.shift())if("*"===o)o=u;else if("*"!==u&&u!==o){if(!(a=l[u+" "+o]||l["* "+o]))for(i in l)if((s=i.split(" "))[1]===o&&(a=l[u+" "+s[0]]||l["* "+s[0]])){!0===a?a=l[i]:!0!==l[i]&&(o=s[0],c.unshift(s[1]));break}if(!0!==a)if(a&&e["throws"])t=a(t);else try{t=a(t)}catch(e){return{state:"parsererror",error:a?e:"No conversion from "+u+" to "+o}}}return{state:"success",data:t}}w.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:Ct.href,type:"GET",isLocal:Pt.test(Ct.protocol),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":$t,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/\bxml\b/,html:/\bhtml/,json:/\bjson\b/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":JSON.parse,"text xml":w.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(e,t){return t?zt(zt(e,w.ajaxSettings),t):zt(w.ajaxSettings,e)},ajaxPrefilter:Ft(It),ajaxTransport:Ft(Wt),ajax:function(t,n){"object"==typeof t&&(n=t,t=void 0),n=n||{};var i,o,a,s,u,l,c,f,p,d,h=w.ajaxSetup({},n),g=h.context||h,y=h.context&&(g.nodeType||g.jquery)?w(g):w.event,v=w.Deferred(),m=w.Callbacks("once memory"),x=h.statusCode||{},b={},T={},C="canceled",E={readyState:0,getResponseHeader:function(e){var t;if(c){if(!s){s={};while(t=Ot.exec(a))s[t[1].toLowerCase()]=t[2]}t=s[e.toLowerCase()]}return null==t?null:t},getAllResponseHeaders:function(){return c?a:null},setRequestHeader:function(e,t){return null==c&&(e=T[e.toLowerCase()]=T[e.toLowerCase()]||e,b[e]=t),this},overrideMimeType:function(e){return null==c&&(h.mimeType=e),this},statusCode:function(e){var t;if(e)if(c)E.always(e[E.status]);else for(t in e)x[t]=[x[t],e[t]];return this},abort:function(e){var t=e||C;return i&&i.abort(t),k(0,t),this}};if(v.promise(E),h.url=((t||h.url||Ct.href)+"").replace(Rt,Ct.protocol+"//"),h.type=n.method||n.type||h.method||h.type,h.dataTypes=(h.dataType||"*").toLowerCase().match(M)||[""],null==h.crossDomain){l=r.createElement("a");try{l.href=h.url,l.href=l.href,h.crossDomain=Bt.protocol+"//"+Bt.host!=l.protocol+"//"+l.host}catch(e){h.crossDomain=!0}}if(h.data&&h.processData&&"string"!=typeof h.data&&(h.data=w.param(h.data,h.traditional)),_t(It,h,n,E),c)return E;(f=w.event&&h.global)&&0==w.active++&&w.event.trigger("ajaxStart"),h.type=h.type.toUpperCase(),h.hasContent=!Mt.test(h.type),o=h.url.replace(Lt,""),h.hasContent?h.data&&h.processData&&0===(h.contentType||"").indexOf("application/x-www-form-urlencoded")&&(h.data=h.data.replace(qt,"+")):(d=h.url.slice(o.length),h.data&&(h.processData||"string"==typeof h.data)&&(o+=(kt.test(o)?"&":"?")+h.data,delete h.data),!1===h.cache&&(o=o.replace(Ht,"$1"),d=(kt.test(o)?"&":"?")+"_="+Et+++d),h.url=o+d),h.ifModified&&(w.lastModified[o]&&E.setRequestHeader("If-Modified-Since",w.lastModified[o]),w.etag[o]&&E.setRequestHeader("If-None-Match",w.etag[o])),(h.data&&h.hasContent&&!1!==h.contentType||n.contentType)&&E.setRequestHeader("Content-Type",h.contentType),E.setRequestHeader("Accept",h.dataTypes[0]&&h.accepts[h.dataTypes[0]]?h.accepts[h.dataTypes[0]]+("*"!==h.dataTypes[0]?", "+$t+"; q=0.01":""):h.accepts["*"]);for(p in h.headers)E.setRequestHeader(p,h.headers[p]);if(h.beforeSend&&(!1===h.beforeSend.call(g,E,h)||c))return E.abort();if(C="abort",m.add(h.complete),E.done(h.success),E.fail(h.error),i=_t(Wt,h,n,E)){if(E.readyState=1,f&&y.trigger("ajaxSend",[E,h]),c)return E;h.async&&h.timeout>0&&(u=e.setTimeout(function(){E.abort("timeout")},h.timeout));try{c=!1,i.send(b,k)}catch(e){if(c)throw e;k(-1,e)}}else k(-1,"No Transport");function k(t,n,r,s){var l,p,d,b,T,C=n;c||(c=!0,u&&e.clearTimeout(u),i=void 0,a=s||"",E.readyState=t>0?4:0,l=t>=200&&t<300||304===t,r&&(b=Xt(h,E,r)),b=Ut(h,b,E,l),l?(h.ifModified&&((T=E.getResponseHeader("Last-Modified"))&&(w.lastModified[o]=T),(T=E.getResponseHeader("etag"))&&(w.etag[o]=T)),204===t||"HEAD"===h.type?C="nocontent":304===t?C="notmodified":(C=b.state,p=b.data,l=!(d=b.error))):(d=C,!t&&C||(C="error",t<0&&(t=0))),E.status=t,E.statusText=(n||C)+"",l?v.resolveWith(g,[p,C,E]):v.rejectWith(g,[E,C,d]),E.statusCode(x),x=void 0,f&&y.trigger(l?"ajaxSuccess":"ajaxError",[E,h,l?p:d]),m.fireWith(g,[E,C]),f&&(y.trigger("ajaxComplete",[E,h]),--w.active||w.event.trigger("ajaxStop")))}return E},getJSON:function(e,t,n){return w.get(e,t,n,"json")},getScript:function(e,t){return w.get(e,void 0,t,"script")}}),w.each(["get","post"],function(e,t){w[t]=function(e,n,r,i){return g(n)&&(i=i||r,r=n,n=void 0),w.ajax(w.extend({url:e,type:t,dataType:i,data:n,success:r},w.isPlainObject(e)&&e))}}),w._evalUrl=function(e){return w.ajax({url:e,type:"GET",dataType:"script",cache:!0,async:!1,global:!1,"throws":!0})},w.fn.extend({wrapAll:function(e){var t;return this[0]&&(g(e)&&(e=e.call(this[0])),t=w(e,this[0].ownerDocument).eq(0).clone(!0),this[0].parentNode&&t.insertBefore(this[0]),t.map(function(){var e=this;while(e.firstElementChild)e=e.firstElementChild;return e}).append(this)),this},wrapInner:function(e){return g(e)?this.each(function(t){w(this).wrapInner(e.call(this,t))}):this.each(function(){var t=w(this),n=t.contents();n.length?n.wrapAll(e):t.append(e)})},wrap:function(e){var t=g(e);return this.each(function(n){w(this).wrapAll(t?e.call(this,n):e)})},unwrap:function(e){return this.parent(e).not("body").each(function(){w(this).replaceWith(this.childNodes)}),this}}),w.expr.pseudos.hidden=function(e){return!w.expr.pseudos.visible(e)},w.expr.pseudos.visible=function(e){return!!(e.offsetWidth||e.offsetHeight||e.getClientRects().length)},w.ajaxSettings.xhr=function(){try{return new e.XMLHttpRequest}catch(e){}};var Vt={0:200,1223:204},Gt=w.ajaxSettings.xhr();h.cors=!!Gt&&"withCredentials"in Gt,h.ajax=Gt=!!Gt,w.ajaxTransport(function(t){var n,r;if(h.cors||Gt&&!t.crossDomain)return{send:function(i,o){var a,s=t.xhr();if(s.open(t.type,t.url,t.async,t.username,t.password),t.xhrFields)for(a in t.xhrFields)s[a]=t.xhrFields[a];t.mimeType&&s.overrideMimeType&&s.overrideMimeType(t.mimeType),t.crossDomain||i["X-Requested-With"]||(i["X-Requested-With"]="XMLHttpRequest");for(a in i)s.setRequestHeader(a,i[a]);n=function(e){return function(){n&&(n=r=s.onload=s.onerror=s.onabort=s.ontimeout=s.onreadystatechange=null,"abort"===e?s.abort():"error"===e?"number"!=typeof s.status?o(0,"error"):o(s.status,s.statusText):o(Vt[s.status]||s.status,s.statusText,"text"!==(s.responseType||"text")||"string"!=typeof s.responseText?{binary:s.response}:{text:s.responseText},s.getAllResponseHeaders()))}},s.onload=n(),r=s.onerror=s.ontimeout=n("error"),void 0!==s.onabort?s.onabort=r:s.onreadystatechange=function(){4===s.readyState&&e.setTimeout(function(){n&&r()})},n=n("abort");try{s.send(t.hasContent&&t.data||null)}catch(e){if(n)throw e}},abort:function(){n&&n()}}}),w.ajaxPrefilter(function(e){e.crossDomain&&(e.contents.script=!1)}),w.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/\b(?:java|ecma)script\b/},converters:{"text script":function(e){return w.globalEval(e),e}}}),w.ajaxPrefilter("script",function(e){void 0===e.cache&&(e.cache=!1),e.crossDomain&&(e.type="GET")}),w.ajaxTransport("script",function(e){if(e.crossDomain){var t,n;return{send:function(i,o){t=w("<script>").prop({charset:e.scriptCharset,src:e.url}).on("load error",n=function(e){t.remove(),n=null,e&&o("error"===e.type?404:200,e.type)}),r.head.appendChild(t[0])},abort:function(){n&&n()}}}});var Yt=[],Qt=/(=)\?(?=&|$)|\?\?/;w.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var e=Yt.pop()||w.expando+"_"+Et++;return this[e]=!0,e}}),w.ajaxPrefilter("json jsonp",function(t,n,r){var i,o,a,s=!1!==t.jsonp&&(Qt.test(t.url)?"url":"string"==typeof t.data&&0===(t.contentType||"").indexOf("application/x-www-form-urlencoded")&&Qt.test(t.data)&&"data");if(s||"jsonp"===t.dataTypes[0])return i=t.jsonpCallback=g(t.jsonpCallback)?t.jsonpCallback():t.jsonpCallback,s?t[s]=t[s].replace(Qt,"$1"+i):!1!==t.jsonp&&(t.url+=(kt.test(t.url)?"&":"?")+t.jsonp+"="+i),t.converters["script json"]=function(){return a||w.error(i+" was not called"),a[0]},t.dataTypes[0]="json",o=e[i],e[i]=function(){a=arguments},r.always(function(){void 0===o?w(e).removeProp(i):e[i]=o,t[i]&&(t.jsonpCallback=n.jsonpCallback,Yt.push(i)),a&&g(o)&&o(a[0]),a=o=void 0}),"script"}),h.createHTMLDocument=function(){var e=r.implementation.createHTMLDocument("").body;return e.innerHTML="<form></form><form></form>",2===e.childNodes.length}(),w.parseHTML=function(e,t,n){if("string"!=typeof e)return[];"boolean"==typeof t&&(n=t,t=!1);var i,o,a;return t||(h.createHTMLDocument?((i=(t=r.implementation.createHTMLDocument("")).createElement("base")).href=r.location.href,t.head.appendChild(i)):t=r),o=A.exec(e),a=!n&&[],o?[t.createElement(o[1])]:(o=xe([e],t,a),a&&a.length&&w(a).remove(),w.merge([],o.childNodes))},w.fn.load=function(e,t,n){var r,i,o,a=this,s=e.indexOf(" ");return s>-1&&(r=vt(e.slice(s)),e=e.slice(0,s)),g(t)?(n=t,t=void 0):t&&"object"==typeof t&&(i="POST"),a.length>0&&w.ajax({url:e,type:i||"GET",dataType:"html",data:t}).done(function(e){o=arguments,a.html(r?w("<div>").append(w.parseHTML(e)).find(r):e)}).always(n&&function(e,t){a.each(function(){n.apply(this,o||[e.responseText,t,e])})}),this},w.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(e,t){w.fn[t]=function(e){return this.on(t,e)}}),w.expr.pseudos.animated=function(e){return w.grep(w.timers,function(t){return e===t.elem}).length},w.offset={setOffset:function(e,t,n){var r,i,o,a,s,u,l,c=w.css(e,"position"),f=w(e),p={};"static"===c&&(e.style.position="relative"),s=f.offset(),o=w.css(e,"top"),u=w.css(e,"left"),(l=("absolute"===c||"fixed"===c)&&(o+u).indexOf("auto")>-1)?(a=(r=f.position()).top,i=r.left):(a=parseFloat(o)||0,i=parseFloat(u)||0),g(t)&&(t=t.call(e,n,w.extend({},s))),null!=t.top&&(p.top=t.top-s.top+a),null!=t.left&&(p.left=t.left-s.left+i),"using"in t?t.using.call(e,p):f.css(p)}},w.fn.extend({offset:function(e){if(arguments.length)return void 0===e?this:this.each(function(t){w.offset.setOffset(this,e,t)});var t,n,r=this[0];if(r)return r.getClientRects().length?(t=r.getBoundingClientRect(),n=r.ownerDocument.defaultView,{top:t.top+n.pageYOffset,left:t.left+n.pageXOffset}):{top:0,left:0}},position:function(){if(this[0]){var e,t,n,r=this[0],i={top:0,left:0};if("fixed"===w.css(r,"position"))t=r.getBoundingClientRect();else{t=this.offset(),n=r.ownerDocument,e=r.offsetParent||n.documentElement;while(e&&(e===n.body||e===n.documentElement)&&"static"===w.css(e,"position"))e=e.parentNode;e&&e!==r&&1===e.nodeType&&((i=w(e).offset()).top+=w.css(e,"borderTopWidth",!0),i.left+=w.css(e,"borderLeftWidth",!0))}return{top:t.top-i.top-w.css(r,"marginTop",!0),left:t.left-i.left-w.css(r,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){var e=this.offsetParent;while(e&&"static"===w.css(e,"position"))e=e.offsetParent;return e||be})}}),w.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(e,t){var n="pageYOffset"===t;w.fn[e]=function(r){return z(this,function(e,r,i){var o;if(y(e)?o=e:9===e.nodeType&&(o=e.defaultView),void 0===i)return o?o[t]:e[r];o?o.scrollTo(n?o.pageXOffset:i,n?i:o.pageYOffset):e[r]=i},e,r,arguments.length)}}),w.each(["top","left"],function(e,t){w.cssHooks[t]=_e(h.pixelPosition,function(e,n){if(n)return n=Fe(e,t),We.test(n)?w(e).position()[t]+"px":n})}),w.each({Height:"height",Width:"width"},function(e,t){w.each({padding:"inner"+e,content:t,"":"outer"+e},function(n,r){w.fn[r]=function(i,o){var a=arguments.length&&(n||"boolean"!=typeof i),s=n||(!0===i||!0===o?"margin":"border");return z(this,function(t,n,i){var o;return y(t)?0===r.indexOf("outer")?t["inner"+e]:t.document.documentElement["client"+e]:9===t.nodeType?(o=t.documentElement,Math.max(t.body["scroll"+e],o["scroll"+e],t.body["offset"+e],o["offset"+e],o["client"+e])):void 0===i?w.css(t,n,s):w.style(t,n,i,s)},t,a?i:void 0,a)}})}),w.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "),function(e,t){w.fn[t]=function(e,n){return arguments.length>0?this.on(t,null,e,n):this.trigger(t)}}),w.fn.extend({hover:function(e,t){return this.mouseenter(e).mouseleave(t||e)}}),w.fn.extend({bind:function(e,t,n){return this.on(e,null,t,n)},unbind:function(e,t){return this.off(e,null,t)},delegate:function(e,t,n,r){return this.on(t,e,n,r)},undelegate:function(e,t,n){return 1===arguments.length?this.off(e,"**"):this.off(t,e||"**",n)}}),w.proxy=function(e,t){var n,r,i;if("string"==typeof t&&(n=e[t],t=e,e=n),g(e))return r=o.call(arguments,2),i=function(){return e.apply(t||this,r.concat(o.call(arguments)))},i.guid=e.guid=e.guid||w.guid++,i},w.holdReady=function(e){e?w.readyWait++:w.ready(!0)},w.isArray=Array.isArray,w.parseJSON=JSON.parse,w.nodeName=N,w.isFunction=g,w.isWindow=y,w.camelCase=G,w.type=x,w.now=Date.now,w.isNumeric=function(e){var t=w.type(e);return("number"===t||"string"===t)&&!isNaN(e-parseFloat(e))},"function"==typeof define&&define.amd&&define("jquery",[],function(){return w});var Jt=e.jQuery,Kt=e.$;return w.noConflict=function(t){return e.$===w&&(e.$=Kt),t&&e.jQuery===w&&(e.jQuery=Jt),w},t||(e.jQuery=e.$=w),w});

/*!
  * Bootstrap v4.1.1 (https://getbootstrap.com/)
  * Copyright 2011-2018 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
  */
!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?e(exports,require("jquery")):"function"==typeof define&&define.amd?define(["exports","jquery"],e):e(t.bootstrap={},t.jQuery)}(this,function(t,e){"use strict";function i(t,e){for(var n=0;n<e.length;n++){var i=e[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}function s(t,e,n){return e&&i(t.prototype,e),n&&i(t,n),t}function c(r){for(var t=1;t<arguments.length;t++){var o=null!=arguments[t]?arguments[t]:{},e=Object.keys(o);"function"==typeof Object.getOwnPropertySymbols&&(e=e.concat(Object.getOwnPropertySymbols(o).filter(function(t){return Object.getOwnPropertyDescriptor(o,t).enumerable}))),e.forEach(function(t){var e,n,i;e=r,i=o[n=t],n in e?Object.defineProperty(e,n,{value:i,enumerable:!0,configurable:!0,writable:!0}):e[n]=i})}return r}for(var r,n,o,a,l,f,h,u,d,p,g,m,_,v,E,y,b,T,C,w,I,D,A,S,O,N,k,L,P,x,j,M,R,H,W,F,U,B,K,V,Q,Y,G,q,z,X,J,Z,$,tt,et,nt,it,rt,ot,st,at,lt,ct,ft,ht,ut,dt,pt,gt=function(i){var e="transitionend";function t(t){var e=this,n=!1;return i(this).one(l.TRANSITION_END,function(){n=!0}),setTimeout(function(){n||l.triggerTransitionEnd(e)},t),this}var l={TRANSITION_END:"bsTransitionEnd",getUID:function(t){for(;t+=~~(1e6*Math.random()),document.getElementById(t););return t},getSelectorFromElement:function(t){var e=t.getAttribute("data-target");e&&"#"!==e||(e=t.getAttribute("href")||"");try{return 0<i(document).find(e).length?e:null}catch(t){return null}},getTransitionDurationFromElement:function(t){if(!t)return 0;var e=i(t).css("transition-duration");return parseFloat(e)?(e=e.split(",")[0],1e3*parseFloat(e)):0},reflow:function(t){return t.offsetHeight},triggerTransitionEnd:function(t){i(t).trigger(e)},supportsTransitionEnd:function(){return Boolean(e)},isElement:function(t){return(t[0]||t).nodeType},typeCheckConfig:function(t,e,n){for(var i in n)if(Object.prototype.hasOwnProperty.call(n,i)){var r=n[i],o=e[i],s=o&&l.isElement(o)?"element":(a=o,{}.toString.call(a).match(/\s([a-z]+)/i)[1].toLowerCase());if(!new RegExp(r).test(s))throw new Error(t.toUpperCase()+': Option "'+i+'" provided type "'+s+'" but expected type "'+r+'".')}var a}};return i.fn.emulateTransitionEnd=t,i.event.special[l.TRANSITION_END]={bindType:e,delegateType:e,handle:function(t){if(i(t.target).is(this))return t.handleObj.handler.apply(this,arguments)}},l}(e=e&&e.hasOwnProperty("default")?e.default:e),mt=(n="alert",a="."+(o="bs.alert"),l=(r=e).fn[n],f={CLOSE:"close"+a,CLOSED:"closed"+a,CLICK_DATA_API:"click"+a+".data-api"},h="alert",u="fade",d="show",p=function(){function i(t){this._element=t}var t=i.prototype;return t.close=function(t){var e=this._element;t&&(e=this._getRootElement(t)),this._triggerCloseEvent(e).isDefaultPrevented()||this._removeElement(e)},t.dispose=function(){r.removeData(this._element,o),this._element=null},t._getRootElement=function(t){var e=gt.getSelectorFromElement(t),n=!1;return e&&(n=r(e)[0]),n||(n=r(t).closest("."+h)[0]),n},t._triggerCloseEvent=function(t){var e=r.Event(f.CLOSE);return r(t).trigger(e),e},t._removeElement=function(e){var n=this;if(r(e).removeClass(d),r(e).hasClass(u)){var t=gt.getTransitionDurationFromElement(e);r(e).one(gt.TRANSITION_END,function(t){return n._destroyElement(e,t)}).emulateTransitionEnd(t)}else this._destroyElement(e)},t._destroyElement=function(t){r(t).detach().trigger(f.CLOSED).remove()},i._jQueryInterface=function(n){return this.each(function(){var t=r(this),e=t.data(o);e||(e=new i(this),t.data(o,e)),"close"===n&&e[n](this)})},i._handleDismiss=function(e){return function(t){t&&t.preventDefault(),e.close(this)}},s(i,null,[{key:"VERSION",get:function(){return"4.1.1"}}]),i}(),r(document).on(f.CLICK_DATA_API,'[data-dismiss="alert"]',p._handleDismiss(new p)),r.fn[n]=p._jQueryInterface,r.fn[n].Constructor=p,r.fn[n].noConflict=function(){return r.fn[n]=l,p._jQueryInterface},p),_t=(m="button",v="."+(_="bs.button"),E=".data-api",y=(g=e).fn[m],b="active",T="btn",w='[data-toggle^="button"]',I='[data-toggle="buttons"]',D="input",A=".active",S=".btn",O={CLICK_DATA_API:"click"+v+E,FOCUS_BLUR_DATA_API:(C="focus")+v+E+" blur"+v+E},N=function(){function n(t){this._element=t}var t=n.prototype;return t.toggle=function(){var t=!0,e=!0,n=g(this._element).closest(I)[0];if(n){var i=g(this._element).find(D)[0];if(i){if("radio"===i.type)if(i.checked&&g(this._element).hasClass(b))t=!1;else{var r=g(n).find(A)[0];r&&g(r).removeClass(b)}if(t){if(i.hasAttribute("disabled")||n.hasAttribute("disabled")||i.classList.contains("disabled")||n.classList.contains("disabled"))return;i.checked=!g(this._element).hasClass(b),g(i).trigger("change")}i.focus(),e=!1}}e&&this._element.setAttribute("aria-pressed",!g(this._element).hasClass(b)),t&&g(this._element).toggleClass(b)},t.dispose=function(){g.removeData(this._element,_),this._element=null},n._jQueryInterface=function(e){return this.each(function(){var t=g(this).data(_);t||(t=new n(this),g(this).data(_,t)),"toggle"===e&&t[e]()})},s(n,null,[{key:"VERSION",get:function(){return"4.1.1"}}]),n}(),g(document).on(O.CLICK_DATA_API,w,function(t){t.preventDefault();var e=t.target;g(e).hasClass(T)||(e=g(e).closest(S)),N._jQueryInterface.call(g(e),"toggle")}).on(O.FOCUS_BLUR_DATA_API,w,function(t){var e=g(t.target).closest(S)[0];g(e).toggleClass(C,/^focus(in)?$/.test(t.type))}),g.fn[m]=N._jQueryInterface,g.fn[m].Constructor=N,g.fn[m].noConflict=function(){return g.fn[m]=y,N._jQueryInterface},N),vt=(L="carousel",x="."+(P="bs.carousel"),j=".data-api",M=(k=e).fn[L],R={interval:5e3,keyboard:!0,slide:!1,pause:"hover",wrap:!0},H={interval:"(number|boolean)",keyboard:"boolean",slide:"(boolean|string)",pause:"(string|boolean)",wrap:"boolean"},W="next",F="prev",U="left",B="right",K={SLIDE:"slide"+x,SLID:"slid"+x,KEYDOWN:"keydown"+x,MOUSEENTER:"mouseenter"+x,MOUSELEAVE:"mouseleave"+x,TOUCHEND:"touchend"+x,LOAD_DATA_API:"load"+x+j,CLICK_DATA_API:"click"+x+j},V="carousel",Q="active",Y="slide",G="carousel-item-right",q="carousel-item-left",z="carousel-item-next",X="carousel-item-prev",J={ACTIVE:".active",ACTIVE_ITEM:".active.carousel-item",ITEM:".carousel-item",NEXT_PREV:".carousel-item-next, .carousel-item-prev",INDICATORS:".carousel-indicators",DATA_SLIDE:"[data-slide], [data-slide-to]",DATA_RIDE:'[data-ride="carousel"]'},Z=function(){function o(t,e){this._items=null,this._interval=null,this._activeElement=null,this._isPaused=!1,this._isSliding=!1,this.touchTimeout=null,this._config=this._getConfig(e),this._element=k(t)[0],this._indicatorsElement=k(this._element).find(J.INDICATORS)[0],this._addEventListeners()}var t=o.prototype;return t.next=function(){this._isSliding||this._slide(W)},t.nextWhenVisible=function(){!document.hidden&&k(this._element).is(":visible")&&"hidden"!==k(this._element).css("visibility")&&this.next()},t.prev=function(){this._isSliding||this._slide(F)},t.pause=function(t){t||(this._isPaused=!0),k(this._element).find(J.NEXT_PREV)[0]&&(gt.triggerTransitionEnd(this._element),this.cycle(!0)),clearInterval(this._interval),this._interval=null},t.cycle=function(t){t||(this._isPaused=!1),this._interval&&(clearInterval(this._interval),this._interval=null),this._config.interval&&!this._isPaused&&(this._interval=setInterval((document.visibilityState?this.nextWhenVisible:this.next).bind(this),this._config.interval))},t.to=function(t){var e=this;this._activeElement=k(this._element).find(J.ACTIVE_ITEM)[0];var n=this._getItemIndex(this._activeElement);if(!(t>this._items.length-1||t<0))if(this._isSliding)k(this._element).one(K.SLID,function(){return e.to(t)});else{if(n===t)return this.pause(),void this.cycle();var i=n<t?W:F;this._slide(i,this._items[t])}},t.dispose=function(){k(this._element).off(x),k.removeData(this._element,P),this._items=null,this._config=null,this._element=null,this._interval=null,this._isPaused=null,this._isSliding=null,this._activeElement=null,this._indicatorsElement=null},t._getConfig=function(t){return t=c({},R,t),gt.typeCheckConfig(L,t,H),t},t._addEventListeners=function(){var e=this;this._config.keyboard&&k(this._element).on(K.KEYDOWN,function(t){return e._keydown(t)}),"hover"===this._config.pause&&(k(this._element).on(K.MOUSEENTER,function(t){return e.pause(t)}).on(K.MOUSELEAVE,function(t){return e.cycle(t)}),"ontouchstart"in document.documentElement&&k(this._element).on(K.TOUCHEND,function(){e.pause(),e.touchTimeout&&clearTimeout(e.touchTimeout),e.touchTimeout=setTimeout(function(t){return e.cycle(t)},500+e._config.interval)}))},t._keydown=function(t){if(!/input|textarea/i.test(t.target.tagName))switch(t.which){case 37:t.preventDefault(),this.prev();break;case 39:t.preventDefault(),this.next()}},t._getItemIndex=function(t){return this._items=k.makeArray(k(t).parent().find(J.ITEM)),this._items.indexOf(t)},t._getItemByDirection=function(t,e){var n=t===W,i=t===F,r=this._getItemIndex(e),o=this._items.length-1;if((i&&0===r||n&&r===o)&&!this._config.wrap)return e;var s=(r+(t===F?-1:1))%this._items.length;return-1===s?this._items[this._items.length-1]:this._items[s]},t._triggerSlideEvent=function(t,e){var n=this._getItemIndex(t),i=this._getItemIndex(k(this._element).find(J.ACTIVE_ITEM)[0]),r=k.Event(K.SLIDE,{relatedTarget:t,direction:e,from:i,to:n});return k(this._element).trigger(r),r},t._setActiveIndicatorElement=function(t){if(this._indicatorsElement){k(this._indicatorsElement).find(J.ACTIVE).removeClass(Q);var e=this._indicatorsElement.children[this._getItemIndex(t)];e&&k(e).addClass(Q)}},t._slide=function(t,e){var n,i,r,o=this,s=k(this._element).find(J.ACTIVE_ITEM)[0],a=this._getItemIndex(s),l=e||s&&this._getItemByDirection(t,s),c=this._getItemIndex(l),f=Boolean(this._interval);if(t===W?(n=q,i=z,r=U):(n=G,i=X,r=B),l&&k(l).hasClass(Q))this._isSliding=!1;else if(!this._triggerSlideEvent(l,r).isDefaultPrevented()&&s&&l){this._isSliding=!0,f&&this.pause(),this._setActiveIndicatorElement(l);var h=k.Event(K.SLID,{relatedTarget:l,direction:r,from:a,to:c});if(k(this._element).hasClass(Y)){k(l).addClass(i),gt.reflow(l),k(s).addClass(n),k(l).addClass(n);var u=gt.getTransitionDurationFromElement(s);k(s).one(gt.TRANSITION_END,function(){k(l).removeClass(n+" "+i).addClass(Q),k(s).removeClass(Q+" "+i+" "+n),o._isSliding=!1,setTimeout(function(){return k(o._element).trigger(h)},0)}).emulateTransitionEnd(u)}else k(s).removeClass(Q),k(l).addClass(Q),this._isSliding=!1,k(this._element).trigger(h);f&&this.cycle()}},o._jQueryInterface=function(i){return this.each(function(){var t=k(this).data(P),e=c({},R,k(this).data());"object"==typeof i&&(e=c({},e,i));var n="string"==typeof i?i:e.slide;if(t||(t=new o(this,e),k(this).data(P,t)),"number"==typeof i)t.to(i);else if("string"==typeof n){if("undefined"==typeof t[n])throw new TypeError('No method named "'+n+'"');t[n]()}else e.interval&&(t.pause(),t.cycle())})},o._dataApiClickHandler=function(t){var e=gt.getSelectorFromElement(this);if(e){var n=k(e)[0];if(n&&k(n).hasClass(V)){var i=c({},k(n).data(),k(this).data()),r=this.getAttribute("data-slide-to");r&&(i.interval=!1),o._jQueryInterface.call(k(n),i),r&&k(n).data(P).to(r),t.preventDefault()}}},s(o,null,[{key:"VERSION",get:function(){return"4.1.1"}},{key:"Default",get:function(){return R}}]),o}(),k(document).on(K.CLICK_DATA_API,J.DATA_SLIDE,Z._dataApiClickHandler),k(window).on(K.LOAD_DATA_API,function(){k(J.DATA_RIDE).each(function(){var t=k(this);Z._jQueryInterface.call(t,t.data())})}),k.fn[L]=Z._jQueryInterface,k.fn[L].Constructor=Z,k.fn[L].noConflict=function(){return k.fn[L]=M,Z._jQueryInterface},Z),Et=(tt="collapse",nt="."+(et="bs.collapse"),it=($=e).fn[tt],rt={toggle:!0,parent:""},ot={toggle:"boolean",parent:"(string|element)"},st={SHOW:"show"+nt,SHOWN:"shown"+nt,HIDE:"hide"+nt,HIDDEN:"hidden"+nt,CLICK_DATA_API:"click"+nt+".data-api"},at="show",lt="collapse",ct="collapsing",ft="collapsed",ht="width",ut="height",dt={ACTIVES:".show, .collapsing",DATA_TOGGLE:'[data-toggle="collapse"]'},pt=function(){function a(t,e){this._isTransitioning=!1,this._element=t,this._config=this._getConfig(e),this._triggerArray=$.makeArray($('[data-toggle="collapse"][href="#'+t.id+'"],[data-toggle="collapse"][data-target="#'+t.id+'"]'));for(var n=$(dt.DATA_TOGGLE),i=0;i<n.length;i++){var r=n[i],o=gt.getSelectorFromElement(r);null!==o&&0<$(o).filter(t).length&&(this._selector=o,this._triggerArray.push(r))}this._parent=this._config.parent?this._getParent():null,this._config.parent||this._addAriaAndCollapsedClass(this._element,this._triggerArray),this._config.toggle&&this.toggle()}var t=a.prototype;return t.toggle=function(){$(this._element).hasClass(at)?this.hide():this.show()},t.show=function(){var t,e,n=this;if(!this._isTransitioning&&!$(this._element).hasClass(at)&&(this._parent&&0===(t=$.makeArray($(this._parent).find(dt.ACTIVES).filter('[data-parent="'+this._config.parent+'"]'))).length&&(t=null),!(t&&(e=$(t).not(this._selector).data(et))&&e._isTransitioning))){var i=$.Event(st.SHOW);if($(this._element).trigger(i),!i.isDefaultPrevented()){t&&(a._jQueryInterface.call($(t).not(this._selector),"hide"),e||$(t).data(et,null));var r=this._getDimension();$(this._element).removeClass(lt).addClass(ct),(this._element.style[r]=0)<this._triggerArray.length&&$(this._triggerArray).removeClass(ft).attr("aria-expanded",!0),this.setTransitioning(!0);var o="scroll"+(r[0].toUpperCase()+r.slice(1)),s=gt.getTransitionDurationFromElement(this._element);$(this._element).one(gt.TRANSITION_END,function(){$(n._element).removeClass(ct).addClass(lt).addClass(at),n._element.style[r]="",n.setTransitioning(!1),$(n._element).trigger(st.SHOWN)}).emulateTransitionEnd(s),this._element.style[r]=this._element[o]+"px"}}},t.hide=function(){var t=this;if(!this._isTransitioning&&$(this._element).hasClass(at)){var e=$.Event(st.HIDE);if($(this._element).trigger(e),!e.isDefaultPrevented()){var n=this._getDimension();if(this._element.style[n]=this._element.getBoundingClientRect()[n]+"px",gt.reflow(this._element),$(this._element).addClass(ct).removeClass(lt).removeClass(at),0<this._triggerArray.length)for(var i=0;i<this._triggerArray.length;i++){var r=this._triggerArray[i],o=gt.getSelectorFromElement(r);if(null!==o)$(o).hasClass(at)||$(r).addClass(ft).attr("aria-expanded",!1)}this.setTransitioning(!0);this._element.style[n]="";var s=gt.getTransitionDurationFromElement(this._element);$(this._element).one(gt.TRANSITION_END,function(){t.setTransitioning(!1),$(t._element).removeClass(ct).addClass(lt).trigger(st.HIDDEN)}).emulateTransitionEnd(s)}}},t.setTransitioning=function(t){this._isTransitioning=t},t.dispose=function(){$.removeData(this._element,et),this._config=null,this._parent=null,this._element=null,this._triggerArray=null,this._isTransitioning=null},t._getConfig=function(t){return(t=c({},rt,t)).toggle=Boolean(t.toggle),gt.typeCheckConfig(tt,t,ot),t},t._getDimension=function(){return $(this._element).hasClass(ht)?ht:ut},t._getParent=function(){var n=this,t=null;gt.isElement(this._config.parent)?(t=this._config.parent,"undefined"!=typeof this._config.parent.jquery&&(t=this._config.parent[0])):t=$(this._config.parent)[0];var e='[data-toggle="collapse"][data-parent="'+this._config.parent+'"]';return $(t).find(e).each(function(t,e){n._addAriaAndCollapsedClass(a._getTargetFromElement(e),[e])}),t},t._addAriaAndCollapsedClass=function(t,e){if(t){var n=$(t).hasClass(at);0<e.length&&$(e).toggleClass(ft,!n).attr("aria-expanded",n)}},a._getTargetFromElement=function(t){var e=gt.getSelectorFromElement(t);return e?$(e)[0]:null},a._jQueryInterface=function(i){return this.each(function(){var t=$(this),e=t.data(et),n=c({},rt,t.data(),"object"==typeof i&&i?i:{});if(!e&&n.toggle&&/show|hide/.test(i)&&(n.toggle=!1),e||(e=new a(this,n),t.data(et,e)),"string"==typeof i){if("undefined"==typeof e[i])throw new TypeError('No method named "'+i+'"');e[i]()}})},s(a,null,[{key:"VERSION",get:function(){return"4.1.1"}},{key:"Default",get:function(){return rt}}]),a}(),$(document).on(st.CLICK_DATA_API,dt.DATA_TOGGLE,function(t){"A"===t.currentTarget.tagName&&t.preventDefault();var n=$(this),e=gt.getSelectorFromElement(this);$(e).each(function(){var t=$(this),e=t.data(et)?"toggle":n.data();pt._jQueryInterface.call(t,e)})}),$.fn[tt]=pt._jQueryInterface,$.fn[tt].Constructor=pt,$.fn[tt].noConflict=function(){return $.fn[tt]=it,pt._jQueryInterface},pt),yt="undefined"!=typeof window&&"undefined"!=typeof document,bt=["Edge","Trident","Firefox"],Tt=0,Ct=0;Ct<bt.length;Ct+=1)if(yt&&0<=navigator.userAgent.indexOf(bt[Ct])){Tt=1;break}var wt=yt&&window.Promise?function(t){var e=!1;return function(){e||(e=!0,window.Promise.resolve().then(function(){e=!1,t()}))}}:function(t){var e=!1;return function(){e||(e=!0,setTimeout(function(){e=!1,t()},Tt))}};function It(t){return t&&"[object Function]"==={}.toString.call(t)}function Dt(t,e){if(1!==t.nodeType)return[];var n=getComputedStyle(t,null);return e?n[e]:n}function At(t){return"HTML"===t.nodeName?t:t.parentNode||t.host}function St(t){if(!t)return document.body;switch(t.nodeName){case"HTML":case"BODY":return t.ownerDocument.body;case"#document":return t.body}var e=Dt(t),n=e.overflow,i=e.overflowX,r=e.overflowY;return/(auto|scroll|overlay)/.test(n+r+i)?t:St(At(t))}var Ot=yt&&!(!window.MSInputMethodContext||!document.documentMode),Nt=yt&&/MSIE 10/.test(navigator.userAgent);function kt(t){return 11===t?Ot:10===t?Nt:Ot||Nt}function Lt(t){if(!t)return document.documentElement;for(var e=kt(10)?document.body:null,n=t.offsetParent;n===e&&t.nextElementSibling;)n=(t=t.nextElementSibling).offsetParent;var i=n&&n.nodeName;return i&&"BODY"!==i&&"HTML"!==i?-1!==["TD","TABLE"].indexOf(n.nodeName)&&"static"===Dt(n,"position")?Lt(n):n:t?t.ownerDocument.documentElement:document.documentElement}function Pt(t){return null!==t.parentNode?Pt(t.parentNode):t}function xt(t,e){if(!(t&&t.nodeType&&e&&e.nodeType))return document.documentElement;var n=t.compareDocumentPosition(e)&Node.DOCUMENT_POSITION_FOLLOWING,i=n?t:e,r=n?e:t,o=document.createRange();o.setStart(i,0),o.setEnd(r,0);var s,a,l=o.commonAncestorContainer;if(t!==l&&e!==l||i.contains(r))return"BODY"===(a=(s=l).nodeName)||"HTML"!==a&&Lt(s.firstElementChild)!==s?Lt(l):l;var c=Pt(t);return c.host?xt(c.host,e):xt(t,Pt(e).host)}function jt(t){var e="top"===(1<arguments.length&&void 0!==arguments[1]?arguments[1]:"top")?"scrollTop":"scrollLeft",n=t.nodeName;if("BODY"===n||"HTML"===n){var i=t.ownerDocument.documentElement;return(t.ownerDocument.scrollingElement||i)[e]}return t[e]}function Mt(t,e){var n="x"===e?"Left":"Top",i="Left"===n?"Right":"Bottom";return parseFloat(t["border"+n+"Width"],10)+parseFloat(t["border"+i+"Width"],10)}function Rt(t,e,n,i){return Math.max(e["offset"+t],e["scroll"+t],n["client"+t],n["offset"+t],n["scroll"+t],kt(10)?n["offset"+t]+i["margin"+("Height"===t?"Top":"Left")]+i["margin"+("Height"===t?"Bottom":"Right")]:0)}function Ht(){var t=document.body,e=document.documentElement,n=kt(10)&&getComputedStyle(e);return{height:Rt("Height",t,e,n),width:Rt("Width",t,e,n)}}var Wt=function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")},Ft=function(){function i(t,e){for(var n=0;n<e.length;n++){var i=e[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}return function(t,e,n){return e&&i(t.prototype,e),n&&i(t,n),t}}(),Ut=function(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t},Bt=Object.assign||function(t){for(var e=1;e<arguments.length;e++){var n=arguments[e];for(var i in n)Object.prototype.hasOwnProperty.call(n,i)&&(t[i]=n[i])}return t};function Kt(t){return Bt({},t,{right:t.left+t.width,bottom:t.top+t.height})}function Vt(t){var e={};try{if(kt(10)){e=t.getBoundingClientRect();var n=jt(t,"top"),i=jt(t,"left");e.top+=n,e.left+=i,e.bottom+=n,e.right+=i}else e=t.getBoundingClientRect()}catch(t){}var r={left:e.left,top:e.top,width:e.right-e.left,height:e.bottom-e.top},o="HTML"===t.nodeName?Ht():{},s=o.width||t.clientWidth||r.right-r.left,a=o.height||t.clientHeight||r.bottom-r.top,l=t.offsetWidth-s,c=t.offsetHeight-a;if(l||c){var f=Dt(t);l-=Mt(f,"x"),c-=Mt(f,"y"),r.width-=l,r.height-=c}return Kt(r)}function Qt(t,e){var n=2<arguments.length&&void 0!==arguments[2]&&arguments[2],i=kt(10),r="HTML"===e.nodeName,o=Vt(t),s=Vt(e),a=St(t),l=Dt(e),c=parseFloat(l.borderTopWidth,10),f=parseFloat(l.borderLeftWidth,10);n&&"HTML"===e.nodeName&&(s.top=Math.max(s.top,0),s.left=Math.max(s.left,0));var h=Kt({top:o.top-s.top-c,left:o.left-s.left-f,width:o.width,height:o.height});if(h.marginTop=0,h.marginLeft=0,!i&&r){var u=parseFloat(l.marginTop,10),d=parseFloat(l.marginLeft,10);h.top-=c-u,h.bottom-=c-u,h.left-=f-d,h.right-=f-d,h.marginTop=u,h.marginLeft=d}return(i&&!n?e.contains(a):e===a&&"BODY"!==a.nodeName)&&(h=function(t,e){var n=2<arguments.length&&void 0!==arguments[2]&&arguments[2],i=jt(e,"top"),r=jt(e,"left"),o=n?-1:1;return t.top+=i*o,t.bottom+=i*o,t.left+=r*o,t.right+=r*o,t}(h,e)),h}function Yt(t){if(!t||!t.parentElement||kt())return document.documentElement;for(var e=t.parentElement;e&&"none"===Dt(e,"transform");)e=e.parentElement;return e||document.documentElement}function Gt(t,e,n,i){var r=4<arguments.length&&void 0!==arguments[4]&&arguments[4],o={top:0,left:0},s=r?Yt(t):xt(t,e);if("viewport"===i)o=function(t){var e=1<arguments.length&&void 0!==arguments[1]&&arguments[1],n=t.ownerDocument.documentElement,i=Qt(t,n),r=Math.max(n.clientWidth,window.innerWidth||0),o=Math.max(n.clientHeight,window.innerHeight||0),s=e?0:jt(n),a=e?0:jt(n,"left");return Kt({top:s-i.top+i.marginTop,left:a-i.left+i.marginLeft,width:r,height:o})}(s,r);else{var a=void 0;"scrollParent"===i?"BODY"===(a=St(At(e))).nodeName&&(a=t.ownerDocument.documentElement):a="window"===i?t.ownerDocument.documentElement:i;var l=Qt(a,s,r);if("HTML"!==a.nodeName||function t(e){var n=e.nodeName;return"BODY"!==n&&"HTML"!==n&&("fixed"===Dt(e,"position")||t(At(e)))}(s))o=l;else{var c=Ht(),f=c.height,h=c.width;o.top+=l.top-l.marginTop,o.bottom=f+l.top,o.left+=l.left-l.marginLeft,o.right=h+l.left}}return o.left+=n,o.top+=n,o.right-=n,o.bottom-=n,o}function qt(t,e,i,n,r){var o=5<arguments.length&&void 0!==arguments[5]?arguments[5]:0;if(-1===t.indexOf("auto"))return t;var s=Gt(i,n,o,r),a={top:{width:s.width,height:e.top-s.top},right:{width:s.right-e.right,height:s.height},bottom:{width:s.width,height:s.bottom-e.bottom},left:{width:e.left-s.left,height:s.height}},l=Object.keys(a).map(function(t){return Bt({key:t},a[t],{area:(e=a[t],e.width*e.height)});var e}).sort(function(t,e){return e.area-t.area}),c=l.filter(function(t){var e=t.width,n=t.height;return e>=i.clientWidth&&n>=i.clientHeight}),f=0<c.length?c[0].key:l[0].key,h=t.split("-")[1];return f+(h?"-"+h:"")}function zt(t,e,n){var i=3<arguments.length&&void 0!==arguments[3]?arguments[3]:null;return Qt(n,i?Yt(e):xt(e,n),i)}function Xt(t){var e=getComputedStyle(t),n=parseFloat(e.marginTop)+parseFloat(e.marginBottom),i=parseFloat(e.marginLeft)+parseFloat(e.marginRight);return{width:t.offsetWidth+i,height:t.offsetHeight+n}}function Jt(t){var e={left:"right",right:"left",bottom:"top",top:"bottom"};return t.replace(/left|right|bottom|top/g,function(t){return e[t]})}function Zt(t,e,n){n=n.split("-")[0];var i=Xt(t),r={width:i.width,height:i.height},o=-1!==["right","left"].indexOf(n),s=o?"top":"left",a=o?"left":"top",l=o?"height":"width",c=o?"width":"height";return r[s]=e[s]+e[l]/2-i[l]/2,r[a]=n===a?e[a]-i[c]:e[Jt(a)],r}function $t(t,e){return Array.prototype.find?t.find(e):t.filter(e)[0]}function te(t,n,e){return(void 0===e?t:t.slice(0,function(t,e,n){if(Array.prototype.findIndex)return t.findIndex(function(t){return t[e]===n});var i=$t(t,function(t){return t[e]===n});return t.indexOf(i)}(t,"name",e))).forEach(function(t){t.function&&console.warn("`modifier.function` is deprecated, use `modifier.fn`!");var e=t.function||t.fn;t.enabled&&It(e)&&(n.offsets.popper=Kt(n.offsets.popper),n.offsets.reference=Kt(n.offsets.reference),n=e(n,t))}),n}function ee(t,n){return t.some(function(t){var e=t.name;return t.enabled&&e===n})}function ne(t){for(var e=[!1,"ms","Webkit","Moz","O"],n=t.charAt(0).toUpperCase()+t.slice(1),i=0;i<e.length;i++){var r=e[i],o=r?""+r+n:t;if("undefined"!=typeof document.body.style[o])return o}return null}function ie(t){var e=t.ownerDocument;return e?e.defaultView:window}function re(t,e,n,i){n.updateBound=i,ie(t).addEventListener("resize",n.updateBound,{passive:!0});var r=St(t);return function t(e,n,i,r){var o="BODY"===e.nodeName,s=o?e.ownerDocument.defaultView:e;s.addEventListener(n,i,{passive:!0}),o||t(St(s.parentNode),n,i,r),r.push(s)}(r,"scroll",n.updateBound,n.scrollParents),n.scrollElement=r,n.eventsEnabled=!0,n}function oe(){var t,e;this.state.eventsEnabled&&(cancelAnimationFrame(this.scheduleUpdate),this.state=(t=this.reference,e=this.state,ie(t).removeEventListener("resize",e.updateBound),e.scrollParents.forEach(function(t){t.removeEventListener("scroll",e.updateBound)}),e.updateBound=null,e.scrollParents=[],e.scrollElement=null,e.eventsEnabled=!1,e))}function se(t){return""!==t&&!isNaN(parseFloat(t))&&isFinite(t)}function ae(n,i){Object.keys(i).forEach(function(t){var e="";-1!==["width","height","top","right","bottom","left"].indexOf(t)&&se(i[t])&&(e="px"),n.style[t]=i[t]+e})}function le(t,e,n){var i=$t(t,function(t){return t.name===e}),r=!!i&&t.some(function(t){return t.name===n&&t.enabled&&t.order<i.order});if(!r){var o="`"+e+"`",s="`"+n+"`";console.warn(s+" modifier is required by "+o+" modifier in order to work, be sure to include it before "+o+"!")}return r}var ce=["auto-start","auto","auto-end","top-start","top","top-end","right-start","right","right-end","bottom-end","bottom","bottom-start","left-end","left","left-start"],fe=ce.slice(3);function he(t){var e=1<arguments.length&&void 0!==arguments[1]&&arguments[1],n=fe.indexOf(t),i=fe.slice(n+1).concat(fe.slice(0,n));return e?i.reverse():i}var ue={FLIP:"flip",CLOCKWISE:"clockwise",COUNTERCLOCKWISE:"counterclockwise"};function de(t,r,o,e){var s=[0,0],a=-1!==["right","left"].indexOf(e),n=t.split(/(\+|\-)/).map(function(t){return t.trim()}),i=n.indexOf($t(n,function(t){return-1!==t.search(/,|\s/)}));n[i]&&-1===n[i].indexOf(",")&&console.warn("Offsets separated by white space(s) are deprecated, use a comma (,) instead.");var l=/\s*,\s*|\s+/,c=-1!==i?[n.slice(0,i).concat([n[i].split(l)[0]]),[n[i].split(l)[1]].concat(n.slice(i+1))]:[n];return(c=c.map(function(t,e){var n=(1===e?!a:a)?"height":"width",i=!1;return t.reduce(function(t,e){return""===t[t.length-1]&&-1!==["+","-"].indexOf(e)?(t[t.length-1]=e,i=!0,t):i?(t[t.length-1]+=e,i=!1,t):t.concat(e)},[]).map(function(t){return function(t,e,n,i){var r=t.match(/((?:\-|\+)?\d*\.?\d*)(.*)/),o=+r[1],s=r[2];if(!o)return t;if(0===s.indexOf("%")){var a=void 0;switch(s){case"%p":a=n;break;case"%":case"%r":default:a=i}return Kt(a)[e]/100*o}if("vh"===s||"vw"===s)return("vh"===s?Math.max(document.documentElement.clientHeight,window.innerHeight||0):Math.max(document.documentElement.clientWidth,window.innerWidth||0))/100*o;return o}(t,n,r,o)})})).forEach(function(n,i){n.forEach(function(t,e){se(t)&&(s[i]+=t*("-"===n[e-1]?-1:1))})}),s}var pe={placement:"bottom",positionFixed:!1,eventsEnabled:!0,removeOnDestroy:!1,onCreate:function(){},onUpdate:function(){},modifiers:{shift:{order:100,enabled:!0,fn:function(t){var e=t.placement,n=e.split("-")[0],i=e.split("-")[1];if(i){var r=t.offsets,o=r.reference,s=r.popper,a=-1!==["bottom","top"].indexOf(n),l=a?"left":"top",c=a?"width":"height",f={start:Ut({},l,o[l]),end:Ut({},l,o[l]+o[c]-s[c])};t.offsets.popper=Bt({},s,f[i])}return t}},offset:{order:200,enabled:!0,fn:function(t,e){var n=e.offset,i=t.placement,r=t.offsets,o=r.popper,s=r.reference,a=i.split("-")[0],l=void 0;return l=se(+n)?[+n,0]:de(n,o,s,a),"left"===a?(o.top+=l[0],o.left-=l[1]):"right"===a?(o.top+=l[0],o.left+=l[1]):"top"===a?(o.left+=l[0],o.top-=l[1]):"bottom"===a&&(o.left+=l[0],o.top+=l[1]),t.popper=o,t},offset:0},preventOverflow:{order:300,enabled:!0,fn:function(t,i){var e=i.boundariesElement||Lt(t.instance.popper);t.instance.reference===e&&(e=Lt(e));var n=ne("transform"),r=t.instance.popper.style,o=r.top,s=r.left,a=r[n];r.top="",r.left="",r[n]="";var l=Gt(t.instance.popper,t.instance.reference,i.padding,e,t.positionFixed);r.top=o,r.left=s,r[n]=a,i.boundaries=l;var c=i.priority,f=t.offsets.popper,h={primary:function(t){var e=f[t];return f[t]<l[t]&&!i.escapeWithReference&&(e=Math.max(f[t],l[t])),Ut({},t,e)},secondary:function(t){var e="right"===t?"left":"top",n=f[e];return f[t]>l[t]&&!i.escapeWithReference&&(n=Math.min(f[e],l[t]-("right"===t?f.width:f.height))),Ut({},e,n)}};return c.forEach(function(t){var e=-1!==["left","top"].indexOf(t)?"primary":"secondary";f=Bt({},f,h[e](t))}),t.offsets.popper=f,t},priority:["left","right","top","bottom"],padding:5,boundariesElement:"scrollParent"},keepTogether:{order:400,enabled:!0,fn:function(t){var e=t.offsets,n=e.popper,i=e.reference,r=t.placement.split("-")[0],o=Math.floor,s=-1!==["top","bottom"].indexOf(r),a=s?"right":"bottom",l=s?"left":"top",c=s?"width":"height";return n[a]<o(i[l])&&(t.offsets.popper[l]=o(i[l])-n[c]),n[l]>o(i[a])&&(t.offsets.popper[l]=o(i[a])),t}},arrow:{order:500,enabled:!0,fn:function(t,e){var n;if(!le(t.instance.modifiers,"arrow","keepTogether"))return t;var i=e.element;if("string"==typeof i){if(!(i=t.instance.popper.querySelector(i)))return t}else if(!t.instance.popper.contains(i))return console.warn("WARNING: `arrow.element` must be child of its popper element!"),t;var r=t.placement.split("-")[0],o=t.offsets,s=o.popper,a=o.reference,l=-1!==["left","right"].indexOf(r),c=l?"height":"width",f=l?"Top":"Left",h=f.toLowerCase(),u=l?"left":"top",d=l?"bottom":"right",p=Xt(i)[c];a[d]-p<s[h]&&(t.offsets.popper[h]-=s[h]-(a[d]-p)),a[h]+p>s[d]&&(t.offsets.popper[h]+=a[h]+p-s[d]),t.offsets.popper=Kt(t.offsets.popper);var g=a[h]+a[c]/2-p/2,m=Dt(t.instance.popper),_=parseFloat(m["margin"+f],10),v=parseFloat(m["border"+f+"Width"],10),E=g-t.offsets.popper[h]-_-v;return E=Math.max(Math.min(s[c]-p,E),0),t.arrowElement=i,t.offsets.arrow=(Ut(n={},h,Math.round(E)),Ut(n,u,""),n),t},element:"[x-arrow]"},flip:{order:600,enabled:!0,fn:function(p,g){if(ee(p.instance.modifiers,"inner"))return p;if(p.flipped&&p.placement===p.originalPlacement)return p;var m=Gt(p.instance.popper,p.instance.reference,g.padding,g.boundariesElement,p.positionFixed),_=p.placement.split("-")[0],v=Jt(_),E=p.placement.split("-")[1]||"",y=[];switch(g.behavior){case ue.FLIP:y=[_,v];break;case ue.CLOCKWISE:y=he(_);break;case ue.COUNTERCLOCKWISE:y=he(_,!0);break;default:y=g.behavior}return y.forEach(function(t,e){if(_!==t||y.length===e+1)return p;_=p.placement.split("-")[0],v=Jt(_);var n,i=p.offsets.popper,r=p.offsets.reference,o=Math.floor,s="left"===_&&o(i.right)>o(r.left)||"right"===_&&o(i.left)<o(r.right)||"top"===_&&o(i.bottom)>o(r.top)||"bottom"===_&&o(i.top)<o(r.bottom),a=o(i.left)<o(m.left),l=o(i.right)>o(m.right),c=o(i.top)<o(m.top),f=o(i.bottom)>o(m.bottom),h="left"===_&&a||"right"===_&&l||"top"===_&&c||"bottom"===_&&f,u=-1!==["top","bottom"].indexOf(_),d=!!g.flipVariations&&(u&&"start"===E&&a||u&&"end"===E&&l||!u&&"start"===E&&c||!u&&"end"===E&&f);(s||h||d)&&(p.flipped=!0,(s||h)&&(_=y[e+1]),d&&(E="end"===(n=E)?"start":"start"===n?"end":n),p.placement=_+(E?"-"+E:""),p.offsets.popper=Bt({},p.offsets.popper,Zt(p.instance.popper,p.offsets.reference,p.placement)),p=te(p.instance.modifiers,p,"flip"))}),p},behavior:"flip",padding:5,boundariesElement:"viewport"},inner:{order:700,enabled:!1,fn:function(t){var e=t.placement,n=e.split("-")[0],i=t.offsets,r=i.popper,o=i.reference,s=-1!==["left","right"].indexOf(n),a=-1===["top","left"].indexOf(n);return r[s?"left":"top"]=o[n]-(a?r[s?"width":"height"]:0),t.placement=Jt(e),t.offsets.popper=Kt(r),t}},hide:{order:800,enabled:!0,fn:function(t){if(!le(t.instance.modifiers,"hide","preventOverflow"))return t;var e=t.offsets.reference,n=$t(t.instance.modifiers,function(t){return"preventOverflow"===t.name}).boundaries;if(e.bottom<n.top||e.left>n.right||e.top>n.bottom||e.right<n.left){if(!0===t.hide)return t;t.hide=!0,t.attributes["x-out-of-boundaries"]=""}else{if(!1===t.hide)return t;t.hide=!1,t.attributes["x-out-of-boundaries"]=!1}return t}},computeStyle:{order:850,enabled:!0,fn:function(t,e){var n=e.x,i=e.y,r=t.offsets.popper,o=$t(t.instance.modifiers,function(t){return"applyStyle"===t.name}).gpuAcceleration;void 0!==o&&console.warn("WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!");var s=void 0!==o?o:e.gpuAcceleration,a=Vt(Lt(t.instance.popper)),l={position:r.position},c={left:Math.floor(r.left),top:Math.round(r.top),bottom:Math.round(r.bottom),right:Math.floor(r.right)},f="bottom"===n?"top":"bottom",h="right"===i?"left":"right",u=ne("transform"),d=void 0,p=void 0;if(p="bottom"===f?-a.height+c.bottom:c.top,d="right"===h?-a.width+c.right:c.left,s&&u)l[u]="translate3d("+d+"px, "+p+"px, 0)",l[f]=0,l[h]=0,l.willChange="transform";else{var g="bottom"===f?-1:1,m="right"===h?-1:1;l[f]=p*g,l[h]=d*m,l.willChange=f+", "+h}var _={"x-placement":t.placement};return t.attributes=Bt({},_,t.attributes),t.styles=Bt({},l,t.styles),t.arrowStyles=Bt({},t.offsets.arrow,t.arrowStyles),t},gpuAcceleration:!0,x:"bottom",y:"right"},applyStyle:{order:900,enabled:!0,fn:function(t){var e,n;return ae(t.instance.popper,t.styles),e=t.instance.popper,n=t.attributes,Object.keys(n).forEach(function(t){!1!==n[t]?e.setAttribute(t,n[t]):e.removeAttribute(t)}),t.arrowElement&&Object.keys(t.arrowStyles).length&&ae(t.arrowElement,t.arrowStyles),t},onLoad:function(t,e,n,i,r){var o=zt(r,e,t,n.positionFixed),s=qt(n.placement,o,e,t,n.modifiers.flip.boundariesElement,n.modifiers.flip.padding);return e.setAttribute("x-placement",s),ae(e,{position:n.positionFixed?"fixed":"absolute"}),n},gpuAcceleration:void 0}}},ge=function(){function o(t,e){var n=this,i=2<arguments.length&&void 0!==arguments[2]?arguments[2]:{};Wt(this,o),this.scheduleUpdate=function(){return requestAnimationFrame(n.update)},this.update=wt(this.update.bind(this)),this.options=Bt({},o.Defaults,i),this.state={isDestroyed:!1,isCreated:!1,scrollParents:[]},this.reference=t&&t.jquery?t[0]:t,this.popper=e&&e.jquery?e[0]:e,this.options.modifiers={},Object.keys(Bt({},o.Defaults.modifiers,i.modifiers)).forEach(function(t){n.options.modifiers[t]=Bt({},o.Defaults.modifiers[t]||{},i.modifiers?i.modifiers[t]:{})}),this.modifiers=Object.keys(this.options.modifiers).map(function(t){return Bt({name:t},n.options.modifiers[t])}).sort(function(t,e){return t.order-e.order}),this.modifiers.forEach(function(t){t.enabled&&It(t.onLoad)&&t.onLoad(n.reference,n.popper,n.options,t,n.state)}),this.update();var r=this.options.eventsEnabled;r&&this.enableEventListeners(),this.state.eventsEnabled=r}return Ft(o,[{key:"update",value:function(){return function(){if(!this.state.isDestroyed){var t={instance:this,styles:{},arrowStyles:{},attributes:{},flipped:!1,offsets:{}};t.offsets.reference=zt(this.state,this.popper,this.reference,this.options.positionFixed),t.placement=qt(this.options.placement,t.offsets.reference,this.popper,this.reference,this.options.modifiers.flip.boundariesElement,this.options.modifiers.flip.padding),t.originalPlacement=t.placement,t.positionFixed=this.options.positionFixed,t.offsets.popper=Zt(this.popper,t.offsets.reference,t.placement),t.offsets.popper.position=this.options.positionFixed?"fixed":"absolute",t=te(this.modifiers,t),this.state.isCreated?this.options.onUpdate(t):(this.state.isCreated=!0,this.options.onCreate(t))}}.call(this)}},{key:"destroy",value:function(){return function(){return this.state.isDestroyed=!0,ee(this.modifiers,"applyStyle")&&(this.popper.removeAttribute("x-placement"),this.popper.style.position="",this.popper.style.top="",this.popper.style.left="",this.popper.style.right="",this.popper.style.bottom="",this.popper.style.willChange="",this.popper.style[ne("transform")]=""),this.disableEventListeners(),this.options.removeOnDestroy&&this.popper.parentNode.removeChild(this.popper),this}.call(this)}},{key:"enableEventListeners",value:function(){return function(){this.state.eventsEnabled||(this.state=re(this.reference,this.options,this.state,this.scheduleUpdate))}.call(this)}},{key:"disableEventListeners",value:function(){return oe.call(this)}}]),o}();ge.Utils=("undefined"!=typeof window?window:global).PopperUtils,ge.placements=ce,ge.Defaults=pe;var me,_e,ve,Ee,ye,be,Te,Ce,we,Ie,De,Ae,Se,Oe,Ne,ke,Le,Pe,xe,je,Me,Re,He,We,Fe,Ue,Be,Ke,Ve,Qe,Ye,Ge,qe,ze,Xe,Je,Ze,$e,tn,en,nn,rn,on,sn,an,ln,cn,fn,hn,un,dn,pn,gn,mn,_n,vn,En,yn,bn,Tn,Cn,wn,In,Dn,An,Sn,On,Nn,kn,Ln,Pn,xn,jn,Mn,Rn,Hn,Wn,Fn,Un,Bn,Kn,Vn,Qn,Yn,Gn,qn,zn,Xn,Jn,Zn,$n,ti,ei,ni,ii,ri,oi,si,ai,li,ci,fi,hi,ui,di,pi,gi,mi,_i,vi,Ei,yi,bi,Ti=(_e="dropdown",Ee="."+(ve="bs.dropdown"),ye=".data-api",be=(me=e).fn[_e],Te=new RegExp("38|40|27"),Ce={HIDE:"hide"+Ee,HIDDEN:"hidden"+Ee,SHOW:"show"+Ee,SHOWN:"shown"+Ee,CLICK:"click"+Ee,CLICK_DATA_API:"click"+Ee+ye,KEYDOWN_DATA_API:"keydown"+Ee+ye,KEYUP_DATA_API:"keyup"+Ee+ye},we="disabled",Ie="show",De="dropup",Ae="dropright",Se="dropleft",Oe="dropdown-menu-right",Ne="position-static",ke='[data-toggle="dropdown"]',Le=".dropdown form",Pe=".dropdown-menu",xe=".navbar-nav",je=".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)",Me="top-start",Re="top-end",He="bottom-start",We="bottom-end",Fe="right-start",Ue="left-start",Be={offset:0,flip:!0,boundary:"scrollParent",reference:"toggle",display:"dynamic"},Ke={offset:"(number|string|function)",flip:"boolean",boundary:"(string|element)",reference:"(string|element)",display:"string"},Ve=function(){function l(t,e){this._element=t,this._popper=null,this._config=this._getConfig(e),this._menu=this._getMenuElement(),this._inNavbar=this._detectNavbar(),this._addEventListeners()}var t=l.prototype;return t.toggle=function(){if(!this._element.disabled&&!me(this._element).hasClass(we)){var t=l._getParentFromElement(this._element),e=me(this._menu).hasClass(Ie);if(l._clearMenus(),!e){var n={relatedTarget:this._element},i=me.Event(Ce.SHOW,n);if(me(t).trigger(i),!i.isDefaultPrevented()){if(!this._inNavbar){if("undefined"==typeof ge)throw new TypeError("Bootstrap dropdown require Popper.js (https://popper.js.org)");var r=this._element;"parent"===this._config.reference?r=t:gt.isElement(this._config.reference)&&(r=this._config.reference,"undefined"!=typeof this._config.reference.jquery&&(r=this._config.reference[0])),"scrollParent"!==this._config.boundary&&me(t).addClass(Ne),this._popper=new ge(r,this._menu,this._getPopperConfig())}"ontouchstart"in document.documentElement&&0===me(t).closest(xe).length&&me(document.body).children().on("mouseover",null,me.noop),this._element.focus(),this._element.setAttribute("aria-expanded",!0),me(this._menu).toggleClass(Ie),me(t).toggleClass(Ie).trigger(me.Event(Ce.SHOWN,n))}}}},t.dispose=function(){me.removeData(this._element,ve),me(this._element).off(Ee),this._element=null,(this._menu=null)!==this._popper&&(this._popper.destroy(),this._popper=null)},t.update=function(){this._inNavbar=this._detectNavbar(),null!==this._popper&&this._popper.scheduleUpdate()},t._addEventListeners=function(){var e=this;me(this._element).on(Ce.CLICK,function(t){t.preventDefault(),t.stopPropagation(),e.toggle()})},t._getConfig=function(t){return t=c({},this.constructor.Default,me(this._element).data(),t),gt.typeCheckConfig(_e,t,this.constructor.DefaultType),t},t._getMenuElement=function(){if(!this._menu){var t=l._getParentFromElement(this._element);this._menu=me(t).find(Pe)[0]}return this._menu},t._getPlacement=function(){var t=me(this._element).parent(),e=He;return t.hasClass(De)?(e=Me,me(this._menu).hasClass(Oe)&&(e=Re)):t.hasClass(Ae)?e=Fe:t.hasClass(Se)?e=Ue:me(this._menu).hasClass(Oe)&&(e=We),e},t._detectNavbar=function(){return 0<me(this._element).closest(".navbar").length},t._getPopperConfig=function(){var e=this,t={};"function"==typeof this._config.offset?t.fn=function(t){return t.offsets=c({},t.offsets,e._config.offset(t.offsets)||{}),t}:t.offset=this._config.offset;var n={placement:this._getPlacement(),modifiers:{offset:t,flip:{enabled:this._config.flip},preventOverflow:{boundariesElement:this._config.boundary}}};return"static"===this._config.display&&(n.modifiers.applyStyle={enabled:!1}),n},l._jQueryInterface=function(e){return this.each(function(){var t=me(this).data(ve);if(t||(t=new l(this,"object"==typeof e?e:null),me(this).data(ve,t)),"string"==typeof e){if("undefined"==typeof t[e])throw new TypeError('No method named "'+e+'"');t[e]()}})},l._clearMenus=function(t){if(!t||3!==t.which&&("keyup"!==t.type||9===t.which))for(var e=me.makeArray(me(ke)),n=0;n<e.length;n++){var i=l._getParentFromElement(e[n]),r=me(e[n]).data(ve),o={relatedTarget:e[n]};if(r){var s=r._menu;if(me(i).hasClass(Ie)&&!(t&&("click"===t.type&&/input|textarea/i.test(t.target.tagName)||"keyup"===t.type&&9===t.which)&&me.contains(i,t.target))){var a=me.Event(Ce.HIDE,o);me(i).trigger(a),a.isDefaultPrevented()||("ontouchstart"in document.documentElement&&me(document.body).children().off("mouseover",null,me.noop),e[n].setAttribute("aria-expanded","false"),me(s).removeClass(Ie),me(i).removeClass(Ie).trigger(me.Event(Ce.HIDDEN,o)))}}}},l._getParentFromElement=function(t){var e,n=gt.getSelectorFromElement(t);return n&&(e=me(n)[0]),e||t.parentNode},l._dataApiKeydownHandler=function(t){if((/input|textarea/i.test(t.target.tagName)?!(32===t.which||27!==t.which&&(40!==t.which&&38!==t.which||me(t.target).closest(Pe).length)):Te.test(t.which))&&(t.preventDefault(),t.stopPropagation(),!this.disabled&&!me(this).hasClass(we))){var e=l._getParentFromElement(this),n=me(e).hasClass(Ie);if((n||27===t.which&&32===t.which)&&(!n||27!==t.which&&32!==t.which)){var i=me(e).find(je).get();if(0!==i.length){var r=i.indexOf(t.target);38===t.which&&0<r&&r--,40===t.which&&r<i.length-1&&r++,r<0&&(r=0),i[r].focus()}}else{if(27===t.which){var o=me(e).find(ke)[0];me(o).trigger("focus")}me(this).trigger("click")}}},s(l,null,[{key:"VERSION",get:function(){return"4.1.1"}},{key:"Default",get:function(){return Be}},{key:"DefaultType",get:function(){return Ke}}]),l}(),me(document).on(Ce.KEYDOWN_DATA_API,ke,Ve._dataApiKeydownHandler).on(Ce.KEYDOWN_DATA_API,Pe,Ve._dataApiKeydownHandler).on(Ce.CLICK_DATA_API+" "+Ce.KEYUP_DATA_API,Ve._clearMenus).on(Ce.CLICK_DATA_API,ke,function(t){t.preventDefault(),t.stopPropagation(),Ve._jQueryInterface.call(me(this),"toggle")}).on(Ce.CLICK_DATA_API,Le,function(t){t.stopPropagation()}),me.fn[_e]=Ve._jQueryInterface,me.fn[_e].Constructor=Ve,me.fn[_e].noConflict=function(){return me.fn[_e]=be,Ve._jQueryInterface},Ve),Ci=(Ye="modal",qe="."+(Ge="bs.modal"),ze=(Qe=e).fn[Ye],Xe={backdrop:!0,keyboard:!0,focus:!0,show:!0},Je={backdrop:"(boolean|string)",keyboard:"boolean",focus:"boolean",show:"boolean"},Ze={HIDE:"hide"+qe,HIDDEN:"hidden"+qe,SHOW:"show"+qe,SHOWN:"shown"+qe,FOCUSIN:"focusin"+qe,RESIZE:"resize"+qe,CLICK_DISMISS:"click.dismiss"+qe,KEYDOWN_DISMISS:"keydown.dismiss"+qe,MOUSEUP_DISMISS:"mouseup.dismiss"+qe,MOUSEDOWN_DISMISS:"mousedown.dismiss"+qe,CLICK_DATA_API:"click"+qe+".data-api"},$e="modal-scrollbar-measure",tn="modal-backdrop",en="modal-open",nn="fade",rn="show",on={DIALOG:".modal-dialog",DATA_TOGGLE:'[data-toggle="modal"]',DATA_DISMISS:'[data-dismiss="modal"]',FIXED_CONTENT:".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",STICKY_CONTENT:".sticky-top",NAVBAR_TOGGLER:".navbar-toggler"},sn=function(){function r(t,e){this._config=this._getConfig(e),this._element=t,this._dialog=Qe(t).find(on.DIALOG)[0],this._backdrop=null,this._isShown=!1,this._isBodyOverflowing=!1,this._ignoreBackdropClick=!1,this._scrollbarWidth=0}var t=r.prototype;return t.toggle=function(t){return this._isShown?this.hide():this.show(t)},t.show=function(t){var e=this;if(!this._isTransitioning&&!this._isShown){Qe(this._element).hasClass(nn)&&(this._isTransitioning=!0);var n=Qe.Event(Ze.SHOW,{relatedTarget:t});Qe(this._element).trigger(n),this._isShown||n.isDefaultPrevented()||(this._isShown=!0,this._checkScrollbar(),this._setScrollbar(),this._adjustDialog(),Qe(document.body).addClass(en),this._setEscapeEvent(),this._setResizeEvent(),Qe(this._element).on(Ze.CLICK_DISMISS,on.DATA_DISMISS,function(t){return e.hide(t)}),Qe(this._dialog).on(Ze.MOUSEDOWN_DISMISS,function(){Qe(e._element).one(Ze.MOUSEUP_DISMISS,function(t){Qe(t.target).is(e._element)&&(e._ignoreBackdropClick=!0)})}),this._showBackdrop(function(){return e._showElement(t)}))}},t.hide=function(t){var e=this;if(t&&t.preventDefault(),!this._isTransitioning&&this._isShown){var n=Qe.Event(Ze.HIDE);if(Qe(this._element).trigger(n),this._isShown&&!n.isDefaultPrevented()){this._isShown=!1;var i=Qe(this._element).hasClass(nn);if(i&&(this._isTransitioning=!0),this._setEscapeEvent(),this._setResizeEvent(),Qe(document).off(Ze.FOCUSIN),Qe(this._element).removeClass(rn),Qe(this._element).off(Ze.CLICK_DISMISS),Qe(this._dialog).off(Ze.MOUSEDOWN_DISMISS),i){var r=gt.getTransitionDurationFromElement(this._element);Qe(this._element).one(gt.TRANSITION_END,function(t){return e._hideModal(t)}).emulateTransitionEnd(r)}else this._hideModal()}}},t.dispose=function(){Qe.removeData(this._element,Ge),Qe(window,document,this._element,this._backdrop).off(qe),this._config=null,this._element=null,this._dialog=null,this._backdrop=null,this._isShown=null,this._isBodyOverflowing=null,this._ignoreBackdropClick=null,this._scrollbarWidth=null},t.handleUpdate=function(){this._adjustDialog()},t._getConfig=function(t){return t=c({},Xe,t),gt.typeCheckConfig(Ye,t,Je),t},t._showElement=function(t){var e=this,n=Qe(this._element).hasClass(nn);this._element.parentNode&&this._element.parentNode.nodeType===Node.ELEMENT_NODE||document.body.appendChild(this._element),this._element.style.display="block",this._element.removeAttribute("aria-hidden"),this._element.scrollTop=0,n&&gt.reflow(this._element),Qe(this._element).addClass(rn),this._config.focus&&this._enforceFocus();var i=Qe.Event(Ze.SHOWN,{relatedTarget:t}),r=function(){e._config.focus&&e._element.focus(),e._isTransitioning=!1,Qe(e._element).trigger(i)};if(n){var o=gt.getTransitionDurationFromElement(this._element);Qe(this._dialog).one(gt.TRANSITION_END,r).emulateTransitionEnd(o)}else r()},t._enforceFocus=function(){var e=this;Qe(document).off(Ze.FOCUSIN).on(Ze.FOCUSIN,function(t){document!==t.target&&e._element!==t.target&&0===Qe(e._element).has(t.target).length&&e._element.focus()})},t._setEscapeEvent=function(){var e=this;this._isShown&&this._config.keyboard?Qe(this._element).on(Ze.KEYDOWN_DISMISS,function(t){27===t.which&&(t.preventDefault(),e.hide())}):this._isShown||Qe(this._element).off(Ze.KEYDOWN_DISMISS)},t._setResizeEvent=function(){var e=this;this._isShown?Qe(window).on(Ze.RESIZE,function(t){return e.handleUpdate(t)}):Qe(window).off(Ze.RESIZE)},t._hideModal=function(){var t=this;this._element.style.display="none",this._element.setAttribute("aria-hidden",!0),this._isTransitioning=!1,this._showBackdrop(function(){Qe(document.body).removeClass(en),t._resetAdjustments(),t._resetScrollbar(),Qe(t._element).trigger(Ze.HIDDEN)})},t._removeBackdrop=function(){this._backdrop&&(Qe(this._backdrop).remove(),this._backdrop=null)},t._showBackdrop=function(t){var e=this,n=Qe(this._element).hasClass(nn)?nn:"";if(this._isShown&&this._config.backdrop){if(this._backdrop=document.createElement("div"),this._backdrop.className=tn,n&&Qe(this._backdrop).addClass(n),Qe(this._backdrop).appendTo(document.body),Qe(this._element).on(Ze.CLICK_DISMISS,function(t){e._ignoreBackdropClick?e._ignoreBackdropClick=!1:t.target===t.currentTarget&&("static"===e._config.backdrop?e._element.focus():e.hide())}),n&&gt.reflow(this._backdrop),Qe(this._backdrop).addClass(rn),!t)return;if(!n)return void t();var i=gt.getTransitionDurationFromElement(this._backdrop);Qe(this._backdrop).one(gt.TRANSITION_END,t).emulateTransitionEnd(i)}else if(!this._isShown&&this._backdrop){Qe(this._backdrop).removeClass(rn);var r=function(){e._removeBackdrop(),t&&t()};if(Qe(this._element).hasClass(nn)){var o=gt.getTransitionDurationFromElement(this._backdrop);Qe(this._backdrop).one(gt.TRANSITION_END,r).emulateTransitionEnd(o)}else r()}else t&&t()},t._adjustDialog=function(){var t=this._element.scrollHeight>document.documentElement.clientHeight;!this._isBodyOverflowing&&t&&(this._element.style.paddingLeft=this._scrollbarWidth+"px"),this._isBodyOverflowing&&!t&&(this._element.style.paddingRight=this._scrollbarWidth+"px")},t._resetAdjustments=function(){this._element.style.paddingLeft="",this._element.style.paddingRight=""},t._checkScrollbar=function(){var t=document.body.getBoundingClientRect();this._isBodyOverflowing=t.left+t.right<window.innerWidth,this._scrollbarWidth=this._getScrollbarWidth()},t._setScrollbar=function(){var r=this;if(this._isBodyOverflowing){Qe(on.FIXED_CONTENT).each(function(t,e){var n=Qe(e)[0].style.paddingRight,i=Qe(e).css("padding-right");Qe(e).data("padding-right",n).css("padding-right",parseFloat(i)+r._scrollbarWidth+"px")}),Qe(on.STICKY_CONTENT).each(function(t,e){var n=Qe(e)[0].style.marginRight,i=Qe(e).css("margin-right");Qe(e).data("margin-right",n).css("margin-right",parseFloat(i)-r._scrollbarWidth+"px")}),Qe(on.NAVBAR_TOGGLER).each(function(t,e){var n=Qe(e)[0].style.marginRight,i=Qe(e).css("margin-right");Qe(e).data("margin-right",n).css("margin-right",parseFloat(i)+r._scrollbarWidth+"px")});var t=document.body.style.paddingRight,e=Qe(document.body).css("padding-right");Qe(document.body).data("padding-right",t).css("padding-right",parseFloat(e)+this._scrollbarWidth+"px")}},t._resetScrollbar=function(){Qe(on.FIXED_CONTENT).each(function(t,e){var n=Qe(e).data("padding-right");"undefined"!=typeof n&&Qe(e).css("padding-right",n).removeData("padding-right")}),Qe(on.STICKY_CONTENT+", "+on.NAVBAR_TOGGLER).each(function(t,e){var n=Qe(e).data("margin-right");"undefined"!=typeof n&&Qe(e).css("margin-right",n).removeData("margin-right")});var t=Qe(document.body).data("padding-right");"undefined"!=typeof t&&Qe(document.body).css("padding-right",t).removeData("padding-right")},t._getScrollbarWidth=function(){var t=document.createElement("div");t.className=$e,document.body.appendChild(t);var e=t.getBoundingClientRect().width-t.clientWidth;return document.body.removeChild(t),e},r._jQueryInterface=function(n,i){return this.each(function(){var t=Qe(this).data(Ge),e=c({},Xe,Qe(this).data(),"object"==typeof n&&n?n:{});if(t||(t=new r(this,e),Qe(this).data(Ge,t)),"string"==typeof n){if("undefined"==typeof t[n])throw new TypeError('No method named "'+n+'"');t[n](i)}else e.show&&t.show(i)})},s(r,null,[{key:"VERSION",get:function(){return"4.1.1"}},{key:"Default",get:function(){return Xe}}]),r}(),Qe(document).on(Ze.CLICK_DATA_API,on.DATA_TOGGLE,function(t){var e,n=this,i=gt.getSelectorFromElement(this);i&&(e=Qe(i)[0]);var r=Qe(e).data(Ge)?"toggle":c({},Qe(e).data(),Qe(this).data());"A"!==this.tagName&&"AREA"!==this.tagName||t.preventDefault();var o=Qe(e).one(Ze.SHOW,function(t){t.isDefaultPrevented()||o.one(Ze.HIDDEN,function(){Qe(n).is(":visible")&&n.focus()})});sn._jQueryInterface.call(Qe(e),r,this)}),Qe.fn[Ye]=sn._jQueryInterface,Qe.fn[Ye].Constructor=sn,Qe.fn[Ye].noConflict=function(){return Qe.fn[Ye]=ze,sn._jQueryInterface},sn),wi=(ln="tooltip",fn="."+(cn="bs.tooltip"),hn=(an=e).fn[ln],un="bs-tooltip",dn=new RegExp("(^|\\s)"+un+"\\S+","g"),mn={animation:!0,template:'<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!(gn={AUTO:"auto",TOP:"top",RIGHT:"right",BOTTOM:"bottom",LEFT:"left"}),selector:!(pn={animation:"boolean",template:"string",title:"(string|element|function)",trigger:"string",delay:"(number|object)",html:"boolean",selector:"(string|boolean)",placement:"(string|function)",offset:"(number|string)",container:"(string|element|boolean)",fallbackPlacement:"(string|array)",boundary:"(string|element)"}),placement:"top",offset:0,container:!1,fallbackPlacement:"flip",boundary:"scrollParent"},vn="out",En={HIDE:"hide"+fn,HIDDEN:"hidden"+fn,SHOW:(_n="show")+fn,SHOWN:"shown"+fn,INSERTED:"inserted"+fn,CLICK:"click"+fn,FOCUSIN:"focusin"+fn,FOCUSOUT:"focusout"+fn,MOUSEENTER:"mouseenter"+fn,MOUSELEAVE:"mouseleave"+fn},yn="fade",bn="show",Tn=".tooltip-inner",Cn=".arrow",wn="hover",In="focus",Dn="click",An="manual",Sn=function(){function i(t,e){if("undefined"==typeof ge)throw new TypeError("Bootstrap tooltips require Popper.js (https://popper.js.org)");this._isEnabled=!0,this._timeout=0,this._hoverState="",this._activeTrigger={},this._popper=null,this.element=t,this.config=this._getConfig(e),this.tip=null,this._setListeners()}var t=i.prototype;return t.enable=function(){this._isEnabled=!0},t.disable=function(){this._isEnabled=!1},t.toggleEnabled=function(){this._isEnabled=!this._isEnabled},t.toggle=function(t){if(this._isEnabled)if(t){var e=this.constructor.DATA_KEY,n=an(t.currentTarget).data(e);n||(n=new this.constructor(t.currentTarget,this._getDelegateConfig()),an(t.currentTarget).data(e,n)),n._activeTrigger.click=!n._activeTrigger.click,n._isWithActiveTrigger()?n._enter(null,n):n._leave(null,n)}else{if(an(this.getTipElement()).hasClass(bn))return void this._leave(null,this);this._enter(null,this)}},t.dispose=function(){clearTimeout(this._timeout),an.removeData(this.element,this.constructor.DATA_KEY),an(this.element).off(this.constructor.EVENT_KEY),an(this.element).closest(".modal").off("hide.bs.modal"),this.tip&&an(this.tip).remove(),this._isEnabled=null,this._timeout=null,this._hoverState=null,(this._activeTrigger=null)!==this._popper&&this._popper.destroy(),this._popper=null,this.element=null,this.config=null,this.tip=null},t.show=function(){var e=this;if("none"===an(this.element).css("display"))throw new Error("Please use show on visible elements");var t=an.Event(this.constructor.Event.SHOW);if(this.isWithContent()&&this._isEnabled){an(this.element).trigger(t);var n=an.contains(this.element.ownerDocument.documentElement,this.element);if(t.isDefaultPrevented()||!n)return;var i=this.getTipElement(),r=gt.getUID(this.constructor.NAME);i.setAttribute("id",r),this.element.setAttribute("aria-describedby",r),this.setContent(),this.config.animation&&an(i).addClass(yn);var o="function"==typeof this.config.placement?this.config.placement.call(this,i,this.element):this.config.placement,s=this._getAttachment(o);this.addAttachmentClass(s);var a=!1===this.config.container?document.body:an(this.config.container);an(i).data(this.constructor.DATA_KEY,this),an.contains(this.element.ownerDocument.documentElement,this.tip)||an(i).appendTo(a),an(this.element).trigger(this.constructor.Event.INSERTED),this._popper=new ge(this.element,i,{placement:s,modifiers:{offset:{offset:this.config.offset},flip:{behavior:this.config.fallbackPlacement},arrow:{element:Cn},preventOverflow:{boundariesElement:this.config.boundary}},onCreate:function(t){t.originalPlacement!==t.placement&&e._handlePopperPlacementChange(t)},onUpdate:function(t){e._handlePopperPlacementChange(t)}}),an(i).addClass(bn),"ontouchstart"in document.documentElement&&an(document.body).children().on("mouseover",null,an.noop);var l=function(){e.config.animation&&e._fixTransition();var t=e._hoverState;e._hoverState=null,an(e.element).trigger(e.constructor.Event.SHOWN),t===vn&&e._leave(null,e)};if(an(this.tip).hasClass(yn)){var c=gt.getTransitionDurationFromElement(this.tip);an(this.tip).one(gt.TRANSITION_END,l).emulateTransitionEnd(c)}else l()}},t.hide=function(t){var e=this,n=this.getTipElement(),i=an.Event(this.constructor.Event.HIDE),r=function(){e._hoverState!==_n&&n.parentNode&&n.parentNode.removeChild(n),e._cleanTipClass(),e.element.removeAttribute("aria-describedby"),an(e.element).trigger(e.constructor.Event.HIDDEN),null!==e._popper&&e._popper.destroy(),t&&t()};if(an(this.element).trigger(i),!i.isDefaultPrevented()){if(an(n).removeClass(bn),"ontouchstart"in document.documentElement&&an(document.body).children().off("mouseover",null,an.noop),this._activeTrigger[Dn]=!1,this._activeTrigger[In]=!1,this._activeTrigger[wn]=!1,an(this.tip).hasClass(yn)){var o=gt.getTransitionDurationFromElement(n);an(n).one(gt.TRANSITION_END,r).emulateTransitionEnd(o)}else r();this._hoverState=""}},t.update=function(){null!==this._popper&&this._popper.scheduleUpdate()},t.isWithContent=function(){return Boolean(this.getTitle())},t.addAttachmentClass=function(t){an(this.getTipElement()).addClass(un+"-"+t)},t.getTipElement=function(){return this.tip=this.tip||an(this.config.template)[0],this.tip},t.setContent=function(){var t=an(this.getTipElement());this.setElementContent(t.find(Tn),this.getTitle()),t.removeClass(yn+" "+bn)},t.setElementContent=function(t,e){var n=this.config.html;"object"==typeof e&&(e.nodeType||e.jquery)?n?an(e).parent().is(t)||t.empty().append(e):t.text(an(e).text()):t[n?"html":"text"](e)},t.getTitle=function(){var t=this.element.getAttribute("data-original-title");return t||(t="function"==typeof this.config.title?this.config.title.call(this.element):this.config.title),t},t._getAttachment=function(t){return gn[t.toUpperCase()]},t._setListeners=function(){var i=this;this.config.trigger.split(" ").forEach(function(t){if("click"===t)an(i.element).on(i.constructor.Event.CLICK,i.config.selector,function(t){return i.toggle(t)});else if(t!==An){var e=t===wn?i.constructor.Event.MOUSEENTER:i.constructor.Event.FOCUSIN,n=t===wn?i.constructor.Event.MOUSELEAVE:i.constructor.Event.FOCUSOUT;an(i.element).on(e,i.config.selector,function(t){return i._enter(t)}).on(n,i.config.selector,function(t){return i._leave(t)})}an(i.element).closest(".modal").on("hide.bs.modal",function(){return i.hide()})}),this.config.selector?this.config=c({},this.config,{trigger:"manual",selector:""}):this._fixTitle()},t._fixTitle=function(){var t=typeof this.element.getAttribute("data-original-title");(this.element.getAttribute("title")||"string"!==t)&&(this.element.setAttribute("data-original-title",this.element.getAttribute("title")||""),this.element.setAttribute("title",""))},t._enter=function(t,e){var n=this.constructor.DATA_KEY;(e=e||an(t.currentTarget).data(n))||(e=new this.constructor(t.currentTarget,this._getDelegateConfig()),an(t.currentTarget).data(n,e)),t&&(e._activeTrigger["focusin"===t.type?In:wn]=!0),an(e.getTipElement()).hasClass(bn)||e._hoverState===_n?e._hoverState=_n:(clearTimeout(e._timeout),e._hoverState=_n,e.config.delay&&e.config.delay.show?e._timeout=setTimeout(function(){e._hoverState===_n&&e.show()},e.config.delay.show):e.show())},t._leave=function(t,e){var n=this.constructor.DATA_KEY;(e=e||an(t.currentTarget).data(n))||(e=new this.constructor(t.currentTarget,this._getDelegateConfig()),an(t.currentTarget).data(n,e)),t&&(e._activeTrigger["focusout"===t.type?In:wn]=!1),e._isWithActiveTrigger()||(clearTimeout(e._timeout),e._hoverState=vn,e.config.delay&&e.config.delay.hide?e._timeout=setTimeout(function(){e._hoverState===vn&&e.hide()},e.config.delay.hide):e.hide())},t._isWithActiveTrigger=function(){for(var t in this._activeTrigger)if(this._activeTrigger[t])return!0;return!1},t._getConfig=function(t){return"number"==typeof(t=c({},this.constructor.Default,an(this.element).data(),"object"==typeof t&&t?t:{})).delay&&(t.delay={show:t.delay,hide:t.delay}),"number"==typeof t.title&&(t.title=t.title.toString()),"number"==typeof t.content&&(t.content=t.content.toString()),gt.typeCheckConfig(ln,t,this.constructor.DefaultType),t},t._getDelegateConfig=function(){var t={};if(this.config)for(var e in this.config)this.constructor.Default[e]!==this.config[e]&&(t[e]=this.config[e]);return t},t._cleanTipClass=function(){var t=an(this.getTipElement()),e=t.attr("class").match(dn);null!==e&&0<e.length&&t.removeClass(e.join(""))},t._handlePopperPlacementChange=function(t){this._cleanTipClass(),this.addAttachmentClass(this._getAttachment(t.placement))},t._fixTransition=function(){var t=this.getTipElement(),e=this.config.animation;null===t.getAttribute("x-placement")&&(an(t).removeClass(yn),this.config.animation=!1,this.hide(),this.show(),this.config.animation=e)},i._jQueryInterface=function(n){return this.each(function(){var t=an(this).data(cn),e="object"==typeof n&&n;if((t||!/dispose|hide/.test(n))&&(t||(t=new i(this,e),an(this).data(cn,t)),"string"==typeof n)){if("undefined"==typeof t[n])throw new TypeError('No method named "'+n+'"');t[n]()}})},s(i,null,[{key:"VERSION",get:function(){return"4.1.1"}},{key:"Default",get:function(){return mn}},{key:"NAME",get:function(){return ln}},{key:"DATA_KEY",get:function(){return cn}},{key:"Event",get:function(){return En}},{key:"EVENT_KEY",get:function(){return fn}},{key:"DefaultType",get:function(){return pn}}]),i}(),an.fn[ln]=Sn._jQueryInterface,an.fn[ln].Constructor=Sn,an.fn[ln].noConflict=function(){return an.fn[ln]=hn,Sn._jQueryInterface},Sn),Ii=(Nn="popover",Ln="."+(kn="bs.popover"),Pn=(On=e).fn[Nn],xn="bs-popover",jn=new RegExp("(^|\\s)"+xn+"\\S+","g"),Mn=c({},wi.Default,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'}),Rn=c({},wi.DefaultType,{content:"(string|element|function)"}),Hn="fade",Fn=".popover-header",Un=".popover-body",Bn={HIDE:"hide"+Ln,HIDDEN:"hidden"+Ln,SHOW:(Wn="show")+Ln,SHOWN:"shown"+Ln,INSERTED:"inserted"+Ln,CLICK:"click"+Ln,FOCUSIN:"focusin"+Ln,FOCUSOUT:"focusout"+Ln,MOUSEENTER:"mouseenter"+Ln,MOUSELEAVE:"mouseleave"+Ln},Kn=function(t){var e,n;function i(){return t.apply(this,arguments)||this}n=t,(e=i).prototype=Object.create(n.prototype),(e.prototype.constructor=e).__proto__=n;var r=i.prototype;return r.isWithContent=function(){return this.getTitle()||this._getContent()},r.addAttachmentClass=function(t){On(this.getTipElement()).addClass(xn+"-"+t)},r.getTipElement=function(){return this.tip=this.tip||On(this.config.template)[0],this.tip},r.setContent=function(){var t=On(this.getTipElement());this.setElementContent(t.find(Fn),this.getTitle());var e=this._getContent();"function"==typeof e&&(e=e.call(this.element)),this.setElementContent(t.find(Un),e),t.removeClass(Hn+" "+Wn)},r._getContent=function(){return this.element.getAttribute("data-content")||this.config.content},r._cleanTipClass=function(){var t=On(this.getTipElement()),e=t.attr("class").match(jn);null!==e&&0<e.length&&t.removeClass(e.join(""))},i._jQueryInterface=function(n){return this.each(function(){var t=On(this).data(kn),e="object"==typeof n?n:null;if((t||!/destroy|hide/.test(n))&&(t||(t=new i(this,e),On(this).data(kn,t)),"string"==typeof n)){if("undefined"==typeof t[n])throw new TypeError('No method named "'+n+'"');t[n]()}})},s(i,null,[{key:"VERSION",get:function(){return"4.1.1"}},{key:"Default",get:function(){return Mn}},{key:"NAME",get:function(){return Nn}},{key:"DATA_KEY",get:function(){return kn}},{key:"Event",get:function(){return Bn}},{key:"EVENT_KEY",get:function(){return Ln}},{key:"DefaultType",get:function(){return Rn}}]),i}(wi),On.fn[Nn]=Kn._jQueryInterface,On.fn[Nn].Constructor=Kn,On.fn[Nn].noConflict=function(){return On.fn[Nn]=Pn,Kn._jQueryInterface},Kn),Di=(Qn="scrollspy",Gn="."+(Yn="bs.scrollspy"),qn=(Vn=e).fn[Qn],zn={offset:10,method:"auto",target:""},Xn={offset:"number",method:"string",target:"(string|element)"},Jn={ACTIVATE:"activate"+Gn,SCROLL:"scroll"+Gn,LOAD_DATA_API:"load"+Gn+".data-api"},Zn="dropdown-item",$n="active",ti={DATA_SPY:'[data-spy="scroll"]',ACTIVE:".active",NAV_LIST_GROUP:".nav, .list-group",NAV_LINKS:".nav-link",NAV_ITEMS:".nav-item",LIST_ITEMS:".list-group-item",DROPDOWN:".dropdown",DROPDOWN_ITEMS:".dropdown-item",DROPDOWN_TOGGLE:".dropdown-toggle"},ei="offset",ni="position",ii=function(){function n(t,e){var n=this;this._element=t,this._scrollElement="BODY"===t.tagName?window:t,this._config=this._getConfig(e),this._selector=this._config.target+" "+ti.NAV_LINKS+","+this._config.target+" "+ti.LIST_ITEMS+","+this._config.target+" "+ti.DROPDOWN_ITEMS,this._offsets=[],this._targets=[],this._activeTarget=null,this._scrollHeight=0,Vn(this._scrollElement).on(Jn.SCROLL,function(t){return n._process(t)}),this.refresh(),this._process()}var t=n.prototype;return t.refresh=function(){var e=this,t=this._scrollElement===this._scrollElement.window?ei:ni,r="auto"===this._config.method?t:this._config.method,o=r===ni?this._getScrollTop():0;this._offsets=[],this._targets=[],this._scrollHeight=this._getScrollHeight(),Vn.makeArray(Vn(this._selector)).map(function(t){var e,n=gt.getSelectorFromElement(t);if(n&&(e=Vn(n)[0]),e){var i=e.getBoundingClientRect();if(i.width||i.height)return[Vn(e)[r]().top+o,n]}return null}).filter(function(t){return t}).sort(function(t,e){return t[0]-e[0]}).forEach(function(t){e._offsets.push(t[0]),e._targets.push(t[1])})},t.dispose=function(){Vn.removeData(this._element,Yn),Vn(this._scrollElement).off(Gn),this._element=null,this._scrollElement=null,this._config=null,this._selector=null,this._offsets=null,this._targets=null,this._activeTarget=null,this._scrollHeight=null},t._getConfig=function(t){if("string"!=typeof(t=c({},zn,"object"==typeof t&&t?t:{})).target){var e=Vn(t.target).attr("id");e||(e=gt.getUID(Qn),Vn(t.target).attr("id",e)),t.target="#"+e}return gt.typeCheckConfig(Qn,t,Xn),t},t._getScrollTop=function(){return this._scrollElement===window?this._scrollElement.pageYOffset:this._scrollElement.scrollTop},t._getScrollHeight=function(){return this._scrollElement.scrollHeight||Math.max(document.body.scrollHeight,document.documentElement.scrollHeight)},t._getOffsetHeight=function(){return this._scrollElement===window?window.innerHeight:this._scrollElement.getBoundingClientRect().height},t._process=function(){var t=this._getScrollTop()+this._config.offset,e=this._getScrollHeight(),n=this._config.offset+e-this._getOffsetHeight();if(this._scrollHeight!==e&&this.refresh(),n<=t){var i=this._targets[this._targets.length-1];this._activeTarget!==i&&this._activate(i)}else{if(this._activeTarget&&t<this._offsets[0]&&0<this._offsets[0])return this._activeTarget=null,void this._clear();for(var r=this._offsets.length;r--;){this._activeTarget!==this._targets[r]&&t>=this._offsets[r]&&("undefined"==typeof this._offsets[r+1]||t<this._offsets[r+1])&&this._activate(this._targets[r])}}},t._activate=function(e){this._activeTarget=e,this._clear();var t=this._selector.split(",");t=t.map(function(t){return t+'[data-target="'+e+'"],'+t+'[href="'+e+'"]'});var n=Vn(t.join(","));n.hasClass(Zn)?(n.closest(ti.DROPDOWN).find(ti.DROPDOWN_TOGGLE).addClass($n),n.addClass($n)):(n.addClass($n),n.parents(ti.NAV_LIST_GROUP).prev(ti.NAV_LINKS+", "+ti.LIST_ITEMS).addClass($n),n.parents(ti.NAV_LIST_GROUP).prev(ti.NAV_ITEMS).children(ti.NAV_LINKS).addClass($n)),Vn(this._scrollElement).trigger(Jn.ACTIVATE,{relatedTarget:e})},t._clear=function(){Vn(this._selector).filter(ti.ACTIVE).removeClass($n)},n._jQueryInterface=function(e){return this.each(function(){var t=Vn(this).data(Yn);if(t||(t=new n(this,"object"==typeof e&&e),Vn(this).data(Yn,t)),"string"==typeof e){if("undefined"==typeof t[e])throw new TypeError('No method named "'+e+'"');t[e]()}})},s(n,null,[{key:"VERSION",get:function(){return"4.1.1"}},{key:"Default",get:function(){return zn}}]),n}(),Vn(window).on(Jn.LOAD_DATA_API,function(){for(var t=Vn.makeArray(Vn(ti.DATA_SPY)),e=t.length;e--;){var n=Vn(t[e]);ii._jQueryInterface.call(n,n.data())}}),Vn.fn[Qn]=ii._jQueryInterface,Vn.fn[Qn].Constructor=ii,Vn.fn[Qn].noConflict=function(){return Vn.fn[Qn]=qn,ii._jQueryInterface},ii),Ai=(si="."+(oi="bs.tab"),ai=(ri=e).fn.tab,li={HIDE:"hide"+si,HIDDEN:"hidden"+si,SHOW:"show"+si,SHOWN:"shown"+si,CLICK_DATA_API:"click"+si+".data-api"},ci="dropdown-menu",fi="active",hi="disabled",ui="fade",di="show",pi=".dropdown",gi=".nav, .list-group",mi=".active",_i="> li > .active",vi='[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]',Ei=".dropdown-toggle",yi="> .dropdown-menu .active",bi=function(){function i(t){this._element=t}var t=i.prototype;return t.show=function(){var n=this;if(!(this._element.parentNode&&this._element.parentNode.nodeType===Node.ELEMENT_NODE&&ri(this._element).hasClass(fi)||ri(this._element).hasClass(hi))){var t,i,e=ri(this._element).closest(gi)[0],r=gt.getSelectorFromElement(this._element);if(e){var o="UL"===e.nodeName?_i:mi;i=(i=ri.makeArray(ri(e).find(o)))[i.length-1]}var s=ri.Event(li.HIDE,{relatedTarget:this._element}),a=ri.Event(li.SHOW,{relatedTarget:i});if(i&&ri(i).trigger(s),ri(this._element).trigger(a),!a.isDefaultPrevented()&&!s.isDefaultPrevented()){r&&(t=ri(r)[0]),this._activate(this._element,e);var l=function(){var t=ri.Event(li.HIDDEN,{relatedTarget:n._element}),e=ri.Event(li.SHOWN,{relatedTarget:i});ri(i).trigger(t),ri(n._element).trigger(e)};t?this._activate(t,t.parentNode,l):l()}}},t.dispose=function(){ri.removeData(this._element,oi),this._element=null},t._activate=function(t,e,n){var i=this,r=("UL"===e.nodeName?ri(e).find(_i):ri(e).children(mi))[0],o=n&&r&&ri(r).hasClass(ui),s=function(){return i._transitionComplete(t,r,n)};if(r&&o){var a=gt.getTransitionDurationFromElement(r);ri(r).one(gt.TRANSITION_END,s).emulateTransitionEnd(a)}else s()},t._transitionComplete=function(t,e,n){if(e){ri(e).removeClass(di+" "+fi);var i=ri(e.parentNode).find(yi)[0];i&&ri(i).removeClass(fi),"tab"===e.getAttribute("role")&&e.setAttribute("aria-selected",!1)}if(ri(t).addClass(fi),"tab"===t.getAttribute("role")&&t.setAttribute("aria-selected",!0),gt.reflow(t),ri(t).addClass(di),t.parentNode&&ri(t.parentNode).hasClass(ci)){var r=ri(t).closest(pi)[0];r&&ri(r).find(Ei).addClass(fi),t.setAttribute("aria-expanded",!0)}n&&n()},i._jQueryInterface=function(n){return this.each(function(){var t=ri(this),e=t.data(oi);if(e||(e=new i(this),t.data(oi,e)),"string"==typeof n){if("undefined"==typeof e[n])throw new TypeError('No method named "'+n+'"');e[n]()}})},s(i,null,[{key:"VERSION",get:function(){return"4.1.1"}}]),i}(),ri(document).on(li.CLICK_DATA_API,vi,function(t){t.preventDefault(),bi._jQueryInterface.call(ri(this),"show")}),ri.fn.tab=bi._jQueryInterface,ri.fn.tab.Constructor=bi,ri.fn.tab.noConflict=function(){return ri.fn.tab=ai,bi._jQueryInterface},bi);!function(t){if("undefined"==typeof t)throw new TypeError("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");var e=t.fn.jquery.split(" ")[0].split(".");if(e[0]<2&&e[1]<9||1===e[0]&&9===e[1]&&e[2]<1||4<=e[0])throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0")}(e),t.Util=gt,t.Alert=mt,t.Button=_t,t.Carousel=vt,t.Collapse=Et,t.Dropdown=Ti,t.Modal=Ci,t.Popover=Ii,t.Scrollspy=Di,t.Tab=Ai,t.Tooltip=wi,Object.defineProperty(t,"__esModule",{value:!0})});

/*! Copyright (c) 2011 Piotr Rochala (http://rocha.la)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Version: 1.3.8
 *
 */
(function(e){e.fn.extend({slimScroll:function(f){var a=e.extend({width:"auto",height:"250px",size:"7px",color:"#000",position:"right",distance:"1px",start:"top",opacity:.4,alwaysVisible:!1,disableFadeOut:!1,railVisible:!1,railColor:"#333",railOpacity:.2,railDraggable:!0,railClass:"slimScrollRail",barClass:"slimScrollBar",wrapperClass:"slimScrollDiv",allowPageScroll:!1,wheelStep:20,touchScrollStep:200,borderRadius:"7px",railBorderRadius:"7px"},f);this.each(function(){function v(d){if(r){d=d||window.event;
var c=0;d.wheelDelta&&(c=-d.wheelDelta/120);d.detail&&(c=d.detail/3);e(d.target||d.srcTarget||d.srcElement).closest("."+a.wrapperClass).is(b.parent())&&n(c,!0);d.preventDefault&&!k&&d.preventDefault();k||(d.returnValue=!1)}}function n(d,g,e){k=!1;var f=b.outerHeight()-c.outerHeight();g&&(g=parseInt(c.css("top"))+d*parseInt(a.wheelStep)/100*c.outerHeight(),g=Math.min(Math.max(g,0),f),g=0<d?Math.ceil(g):Math.floor(g),c.css({top:g+"px"}));l=parseInt(c.css("top"))/(b.outerHeight()-c.outerHeight());g=
l*(b[0].scrollHeight-b.outerHeight());e&&(g=d,d=g/b[0].scrollHeight*b.outerHeight(),d=Math.min(Math.max(d,0),f),c.css({top:d+"px"}));b.scrollTop(g);b.trigger("slimscrolling",~~g);w();p()}function x(){u=Math.max(b.outerHeight()/b[0].scrollHeight*b.outerHeight(),30);c.css({height:u+"px"});var a=u==b.outerHeight()?"none":"block";c.css({display:a})}function w(){x();clearTimeout(B);l==~~l?(k=a.allowPageScroll,C!=l&&b.trigger("slimscroll",0==~~l?"top":"bottom")):k=!1;C=l;u>=b.outerHeight()?k=!0:(c.stop(!0,
!0).fadeIn("fast"),a.railVisible&&m.stop(!0,!0).fadeIn("fast"))}function p(){a.alwaysVisible||(B=setTimeout(function(){a.disableFadeOut&&r||y||z||(c.fadeOut("slow"),m.fadeOut("slow"))},1E3))}var r,y,z,B,A,u,l,C,k=!1,b=e(this);if(b.parent().hasClass(a.wrapperClass)){var q=b.scrollTop(),c=b.siblings("."+a.barClass),m=b.siblings("."+a.railClass);x();if(e.isPlainObject(f)){if("height"in f&&"auto"==f.height){b.parent().css("height","auto");b.css("height","auto");var h=b.parent().parent().height();b.parent().css("height",
h);b.css("height",h)}else"height"in f&&(h=f.height,b.parent().css("height",h),b.css("height",h));if("scrollTo"in f)q=parseInt(a.scrollTo);else if("scrollBy"in f)q+=parseInt(a.scrollBy);else if("destroy"in f){c.remove();m.remove();b.unwrap();return}n(q,!1,!0)}}else if(!(e.isPlainObject(f)&&"destroy"in f)){a.height="auto"==a.height?b.parent().height():a.height;q=e("<div></div>").addClass(a.wrapperClass).css({position:"relative",overflow:"hidden",width:a.width,height:a.height});b.css({overflow:"hidden",
width:a.width,height:a.height});var m=e("<div></div>").addClass(a.railClass).css({width:a.size,height:"100%",position:"absolute",top:0,display:a.alwaysVisible&&a.railVisible?"block":"none","border-radius":a.railBorderRadius,background:a.railColor,opacity:a.railOpacity,zIndex:90}),c=e("<div></div>").addClass(a.barClass).css({background:a.color,width:a.size,position:"absolute",top:0,opacity:a.opacity,display:a.alwaysVisible?"block":"none","border-radius":a.borderRadius,BorderRadius:a.borderRadius,MozBorderRadius:a.borderRadius,
WebkitBorderRadius:a.borderRadius,zIndex:99}),h="right"==a.position?{right:a.distance}:{left:a.distance};m.css(h);c.css(h);b.wrap(q);b.parent().append(c);b.parent().append(m);a.railDraggable&&c.bind("mousedown",function(a){var b=e(document);z=!0;t=parseFloat(c.css("top"));pageY=a.pageY;b.bind("mousemove.slimscroll",function(a){currTop=t+a.pageY-pageY;c.css("top",currTop);n(0,c.position().top,!1)});b.bind("mouseup.slimscroll",function(a){z=!1;p();b.unbind(".slimscroll")});return!1}).bind("selectstart.slimscroll",
function(a){a.stopPropagation();a.preventDefault();return!1});m.hover(function(){w()},function(){p()});c.hover(function(){y=!0},function(){y=!1});b.hover(function(){r=!0;w();p()},function(){r=!1;p()});b.bind("touchstart",function(a,b){a.originalEvent.touches.length&&(A=a.originalEvent.touches[0].pageY)});b.bind("touchmove",function(b){k||b.originalEvent.preventDefault();b.originalEvent.touches.length&&(n((A-b.originalEvent.touches[0].pageY)/a.touchScrollStep,!0),A=b.originalEvent.touches[0].pageY)});
x();"bottom"===a.start?(c.css({top:b.outerHeight()-c.outerHeight()}),n(0,!0)):"top"!==a.start&&(n(e(a.start).position().top,null,!0),a.alwaysVisible||c.hide());window.addEventListener?(this.addEventListener("DOMMouseScroll",v,!1),this.addEventListener("mousewheel",v,!1)):document.attachEvent("onmousewheel",v)}});return this}});e.fn.extend({slimscroll:e.fn.slimScroll})})(jQuery);
/*!
 * Scroll Lock v3.1.3
 * https://github.com/MohammadYounes/jquery-scrollLock
 *
 * Copyright (c) 2017 Mohammad Younes
 * Licensed under GPL 3.
 */
(function(n){typeof define=="function"&&define.amd?define(["jquery"],n):n(jQuery)})(function(n){"use strict";var i={space:32,pageup:33,pagedown:34,end:35,home:36,up:38,down:40},r=function(t,i){var u=i.scrollTop(),h=i.prop("scrollHeight"),c=i.prop("clientHeight"),f=t.originalEvent.wheelDelta||-1*t.originalEvent.detail||-1*t.originalEvent.deltaY,r=0,e,o,s;return t.type==="wheel"?(e=i.height()/n(window).height(),r=t.originalEvent.deltaY*e):this.options.touch&&t.type==="touchmove"&&(f=t.originalEvent.changedTouches[0].clientY-this.startClientY),s=(o=f>0&&u+r<=0)||f<0&&u+r>=h-c,{prevent:s,top:o,scrollTop:u,deltaY:r}},u=function(n,t){var u=t.scrollTop(),r={top:!1,bottom:!1},f,e;return r.top=u===0&&(n.keyCode===i.pageup||n.keyCode===i.home||n.keyCode===i.up),r.top||(f=t.prop("scrollHeight"),e=t.prop("clientHeight"),r.bottom=f===u+e&&(n.keyCode===i.space||n.keyCode===i.pagedown||n.keyCode===i.end||n.keyCode===i.down)),r},t=function(i,r){if(this.$element=i,this.options=n.extend({},t.DEFAULTS,this.$element.data(),r),this.enabled=!0,this.startClientY=0,this.options.unblock)this.$element.on(t.CORE.wheelEventName+t.NAMESPACE,this.options.unblock,n.proxy(t.CORE.unblockHandler,this));this.$element.on(t.CORE.wheelEventName+t.NAMESPACE,this.options.selector,n.proxy(t.CORE.handler,this));if(this.options.touch){this.$element.on("touchstart"+t.NAMESPACE,this.options.selector,n.proxy(t.CORE.touchHandler,this));this.$element.on("touchmove"+t.NAMESPACE,this.options.selector,n.proxy(t.CORE.handler,this));if(this.options.unblock)this.$element.on("touchmove"+t.NAMESPACE,this.options.unblock,n.proxy(t.CORE.unblockHandler,this))}if(this.options.keyboard){this.$element.attr("tabindex",this.options.keyboard.tabindex||0);this.$element.on("keydown"+t.NAMESPACE,this.options.selector,n.proxy(t.CORE.keyboardHandler,this));if(this.options.unblock)this.$element.on("keydown"+t.NAMESPACE,this.options.unblock,n.proxy(t.CORE.unblockHandler,this))}},f;t.NAME="ScrollLock";t.VERSION="3.1.2";t.NAMESPACE=".scrollLock";t.ANIMATION_NAMESPACE=t.NAMESPACE+".effect";t.DEFAULTS={strict:!1,strictFn:function(n){return n.prop("scrollHeight")>n.prop("clientHeight")},selector:!1,animation:!1,touch:"ontouchstart"in window,keyboard:!1,unblock:!1};t.CORE={wheelEventName:"onwheel"in document.createElement("div")?"wheel":document.onmousewheel!==undefined?"mousewheel":"DOMMouseScroll",animationEventName:["webkitAnimationEnd","mozAnimationEnd","MSAnimationEnd","oanimationend","animationend"].join(t.ANIMATION_NAMESPACE+" ")+t.ANIMATION_NAMESPACE,unblockHandler:function(n){n.__currentTarget=n.currentTarget},handler:function(i){var f,u,e;this.enabled&&!i.ctrlKey&&(f=n(i.currentTarget),(this.options.strict!==!0||this.options.strictFn(f))&&(i.stopPropagation(),u=n.proxy(r,this)(i,f),i.__currentTarget&&(u.prevent&=n.proxy(r,this)(i,n(i.__currentTarget)).prevent),u.prevent&&(i.preventDefault(),u.deltaY&&f.scrollTop(u.scrollTop+u.deltaY),e=u.top?"top":"bottom",this.options.animation&&setTimeout(t.CORE.animationHandler.bind(this,f,e),0),f.trigger(n.Event(e+t.NAMESPACE)))))},touchHandler:function(n){this.startClientY=n.originalEvent.touches[0].clientY},animationHandler:function(n,i){var r=this.options.animation[i],u=this.options.animation.top+" "+this.options.animation.bottom;n.off(t.ANIMATION_NAMESPACE).removeClass(u).addClass(r).one(t.CORE.animationEventName,function(){n.removeClass(r)})},keyboardHandler:function(i){var r=n(i.currentTarget),o=r.scrollTop(),f=u(i,r),e;return(i.__currentTarget&&(e=u(i,n(i.__currentTarget)),f.top&=e.top,f.bottom&=e.bottom),f.top)?(r.trigger(n.Event("top"+t.NAMESPACE)),this.options.animation&&setTimeout(t.CORE.animationHandler.bind(this,r,"top"),0),!1):f.bottom?(r.trigger(n.Event("bottom"+t.NAMESPACE)),this.options.animation&&setTimeout(t.CORE.animationHandler.bind(this,r,"bottom"),0),!1):void 0}};t.prototype.toggleStrict=function(){this.options.strict=!this.options.strict};t.prototype.enable=function(){this.enabled=!0};t.prototype.disable=function(){this.enabled=!1};t.prototype.destroy=function(){this.disable();this.$element.off(t.NAMESPACE);this.$element=null;this.options=null};f=n.fn.scrollLock;n.fn.scrollLock=function(i){return this.each(function(){var u=n(this),f=typeof i=="object"&&i,r=u.data(t.NAME);(r||"destroy"!==i)&&(r||u.data(t.NAME,r=new t(u,f)),typeof i=="string"&&r[i]())})};n.fn.scrollLock.defaults=t.DEFAULTS;n.fn.scrollLock.noConflict=function(){return n.fn.scrollLock=f,this}});

!function(e,a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof module&&module.exports?require("jquery"):e.jQuery)}(this,function(e){e.fn.appear=function(a,r){var n=e.extend({data:void 0,one:!0,accX:0,accY:0},r);return this.each(function(){var r=e(this);if(r.appeared=!1,a){var p=e(window),t=function(){if(r.is(":visible")){var e=p.scrollLeft(),a=p.scrollTop(),t=r.offset(),i=t.left,c=t.top,o=n.accX,f=n.accY,s=r.height(),u=p.height(),d=r.width(),l=p.width();c+s+f>=a&&c<=a+u+f&&i+d+o>=e&&i<=e+l+o?r.appeared||r.trigger("appear",n.data):r.appeared=!1}else r.appeared=!1},i=function(){if(r.appeared=!0,n.one){p.unbind("scroll",t);var i=e.inArray(t,e.fn.appear.checks);i>=0&&e.fn.appear.checks.splice(i,1)}a.apply(this,arguments)};n.one?r.one("appear",n.data,i):r.bind("appear",n.data,i),p.scroll(t),e.fn.appear.checks.push(t),t()}else r.trigger("appear",n.data)})},e.extend(e.fn.appear,{checks:[],timeout:null,checkAll:function(){var a=e.fn.appear.checks.length;if(a>0)for(;a--;)e.fn.appear.checks[a]()},run:function(){e.fn.appear.timeout&&clearTimeout(e.fn.appear.timeout),e.fn.appear.timeout=setTimeout(e.fn.appear.checkAll,20)}}),e.each(["append","prepend","after","before","attr","removeAttr","addClass","removeClass","toggleClass","remove","css","show","hide"],function(a,r){var n=e.fn[r];n&&(e.fn[r]=function(){var a=n.apply(this,arguments);return e.fn.appear.run(),a})})});
!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):t("object"==typeof exports?require("jquery"):jQuery)}(function(t){var e=function(o,i){this.$element=t(o),this.options=t.extend({},e.DEFAULTS,this.dataOptions(),i),this.init()};e.DEFAULTS={from:0,to:0,speed:1e3,refreshInterval:100,decimals:0,formatter:function(t,e){return t.toFixed(e.decimals)},onUpdate:null,onComplete:null},e.prototype.init=function(){this.value=this.options.from,this.loops=Math.ceil(this.options.speed/this.options.refreshInterval),this.loopCount=0,this.increment=(this.options.to-this.options.from)/this.loops},e.prototype.dataOptions=function(){var t={from:this.$element.data("from"),to:this.$element.data("to"),speed:this.$element.data("speed"),refreshInterval:this.$element.data("refresh-interval"),decimals:this.$element.data("decimals")},e=Object.keys(t);for(var o in e){var i=e[o];void 0===t[i]&&delete t[i]}return t},e.prototype.update=function(){this.value+=this.increment,this.loopCount++,this.render(),"function"==typeof this.options.onUpdate&&this.options.onUpdate.call(this.$element,this.value),this.loopCount>=this.loops&&(clearInterval(this.interval),this.value=this.options.to,"function"==typeof this.options.onComplete&&this.options.onComplete.call(this.$element,this.value))},e.prototype.render=function(){var t=this.options.formatter.call(this.$element,this.value,this.options);this.$element.text(t)},e.prototype.restart=function(){this.stop(),this.init(),this.start()},e.prototype.start=function(){this.stop(),this.render(),this.interval=setInterval(this.update.bind(this),this.options.refreshInterval)},e.prototype.stop=function(){this.interval&&clearInterval(this.interval)},e.prototype.toggle=function(){this.interval?this.stop():this.start()},t.fn.countTo=function(o){return this.each(function(){var i=t(this),n=i.data("countTo"),s=!n||"object"==typeof o,r="object"==typeof o?o:{},a="string"==typeof o?o:"start";s&&(n&&n.stop(),i.data("countTo",n=new e(this,r))),n[a].call(n)})}});
/*!
 * JavaScript Cookie v2.2.0
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
!function(e){var n=!1;if("function"==typeof define&&define.amd&&(define(e),n=!0),"object"==typeof exports&&(module.exports=e(),n=!0),!n){var o=window.Cookies,t=window.Cookies=e();t.noConflict=function(){return window.Cookies=o,t}}}(function(){function e(){for(var e=0,n={};e<arguments.length;e++){var o=arguments[e];for(var t in o)n[t]=o[t]}return n}function n(o){function t(n,r,i){var c;if("undefined"!=typeof document){if(arguments.length>1){if("number"==typeof(i=e({path:"/"},t.defaults,i)).expires){var a=new Date;a.setMilliseconds(a.getMilliseconds()+864e5*i.expires),i.expires=a}i.expires=i.expires?i.expires.toUTCString():"";try{c=JSON.stringify(r),/^[\{\[]/.test(c)&&(r=c)}catch(e){}r=o.write?o.write(r,n):encodeURIComponent(String(r)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=(n=(n=encodeURIComponent(String(n))).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent)).replace(/[\(\)]/g,escape);var s="";for(var f in i)i[f]&&(s+="; "+f,!0!==i[f]&&(s+="="+i[f]));return document.cookie=n+"="+r+s}n||(c={});for(var p=document.cookie?document.cookie.split("; "):[],d=/(%[0-9A-Z]{2})+/g,u=0;u<p.length;u++){var l=p[u].split("="),C=l.slice(1).join("=");this.json||'"'!==C.charAt(0)||(C=C.slice(1,-1));try{var g=l[0].replace(d,decodeURIComponent);if(C=o.read?o.read(C,g):o(C,g)||C.replace(d,decodeURIComponent),this.json)try{C=JSON.parse(C)}catch(e){}if(n===g){c=C;break}n||(c[g]=C)}catch(e){}}return c}}return t.set=t,t.get=function(e){return t.call(t,e)},t.getJSON=function(){return t.apply({json:!0},[].slice.call(arguments))},t.defaults={},t.remove=function(n,o){t(n,"",e(o,{expires:-1}))},t.withConverter=n,t}return n(function(){})});
/*
 *  Document   : codebase.js
 *  Author     : pixelcave
 *  Description: Codebase - UI Framework Custom Functionality
 *
 */

'use strict';

var Codebase = function() {
    var lHtml,
        lBody,
        lPage,
        lSidebar,
        lSidebarScroll,
        lSideOverlay,
        lSideOverlayScroll,
        lHeader,
        lHeaderSearch,
        lHeaderSearchInput,
        lHeaderLoader,
        lMain,
        lFooter,
        windowW;

    // Set helper variables
    var uiInit = function() {
        lHtml              = jQuery('html');
        lBody              = jQuery('body');
        lPage              = jQuery('#page-container');
        lSidebar           = jQuery('#sidebar');
        lSidebarScroll     = jQuery('#sidebar-scroll');
        lSideOverlay       = jQuery('#side-overlay');
        lSideOverlayScroll = jQuery('#side-overlay-scroll');
        lHeader            = jQuery('#page-header');
        lHeaderSearch      = jQuery('#page-header-search');
        lHeaderSearchInput = jQuery('#page-header-search-input');
        lHeaderLoader      = jQuery('#page-header-loader');
        lMain              = jQuery('#main-container');
        lFooter            = jQuery('#page-footer');
    };

    /*
     ********************************************************************************************
     *
     * BASE UI FUNCTIONALITY
     *
     * Functions which handle vital UI functionality such as main navigation and layout
     * They are auto initialized
     *
     *********************************************************************************************
     */

    // Handles sidebar and side overlay custom scrolling functionality
    var uiHandleScroll = function(mode) {
        windowW = getWidth();

        // Init scrolling
        if (mode === 'init') {
            var sScrollTimeout;

            // Unbind events in case they are already binded
            jQuery(window).off('resize.cb.scroll orientationchange.cb.scroll');

            // Bind the events
            jQuery(window).on('resize.cb.scroll orientationchange.cb.scroll', function(){
                clearTimeout(sScrollTimeout);

                sScrollTimeout = setTimeout(function(){
                    uiHandleScroll();
                }, 150);
            }).triggerHandler('resize.cb.scroll');
        } else {
            // If screen width is greater than 991 pixels and .side-scroll is added to #page-container
            if (windowW > 991 && lPage.hasClass('side-scroll')) {
                // Turn scroll lock off (sidebar and side overlay - slimScroll will take care of it)
                jQuery(lSidebar).add(lSideOverlay).scrollLock('disable');

                // If sidebar scrolling does not exist init it..
                if (lSidebarScroll.length && (!lSidebarScroll.parent('.slimScrollDiv').length)) {
                    lSidebarScroll.slimScroll({
                        height: lSidebar.outerHeight(),
                        color: '#cdcdcd',
                        size: '4px',
                        opacity : .9,
                        wheelStep : 15,
                        distance : '0',
                        railVisible: false,
                        railOpacity: 1
                    });

                    // Small hack, so that scrolling works if the mouse is over the scrolling area on load and hasn't moved yet
                    lSidebarScroll.mouseover();
                }
                else { // ..else resize scrolling height
                    lSidebarScroll
                        .add(lSidebarScroll.parent())
                        .css('height', lSidebar.outerHeight());

                    // Small hack, so that scrolling works if the mouse is over the scrolling area on load and hasn't moved yet
                    lSidebarScroll.mouseover();
                }

                // If side overlay scrolling does not exist init it..
                if (lSideOverlayScroll.length && (!lSideOverlayScroll.parent('.slimScrollDiv').length)) {
                    lSideOverlayScroll.slimScroll({
                        height: lSideOverlay.outerHeight(),
                        color: '#cdcdcd',
                        size: '4px',
                        opacity : .9,
                        wheelStep : 15,
                        distance : '0',
                        railVisible: false,
                        railOpacity: 1
                    });
                }
                else { // ..else resize scrolling height
                    lSideOverlayScroll
                        .add(lSideOverlayScroll.parent())
                        .css('height', lSideOverlay.outerHeight());
                }
            } else {
                // Turn scroll lock on (sidebar and side overlay)
                jQuery(lSidebar).add(lSideOverlay).scrollLock('enable');

                // If sidebar scrolling exists destroy it..
                if (lSidebarScroll.length && lSidebarScroll.parent('.slimScrollDiv').length) {
                    lSidebarScroll
                        .slimScroll({destroy: true});
                    lSidebarScroll
                        .attr('style', '');
                }

                // If side overlay scrolling exists destroy it..
                if (lSideOverlayScroll.length && lSideOverlayScroll.parent('.slimScrollDiv').length) {
                    lSideOverlayScroll
                        .slimScroll({destroy: true});
                    lSideOverlayScroll
                        .attr('style', '');
                }
            }
        }
    };

    // Resizes #main-container to fill empty space if exists (pushes footer to the bottom) + Adds transition to sidebar (small fix for IE)
    var uiHandleMain = function() {
        var resizeTimeout;

        // Unbind events in case they are already binded
        jQuery(window).off('resize.cb.main orientationchange.cb.main');

        // If #main-container element exists
        if (lMain.length) {
            jQuery(window).on('resize.cb.main orientationchange.cb.main', function(){
                clearTimeout(resizeTimeout);

                resizeTimeout = setTimeout(function(){
                    var hWindow     = jQuery(window).height();
                    var hHeader     = lHeader.outerHeight() || 0;
                    var hFooter     = lFooter.outerHeight() || 0;

                    // Set #main-container min height accordingly
                    if (lPage.hasClass('page-header-fixed') || lPage.hasClass('page-header-glass')) {
                        lMain.css('min-height', hWindow - hFooter);
                    } else {
                        lMain.css('min-height', hWindow - hHeader - hFooter);
                    }

                    // Show footer's content
                    lFooter.fadeTo(1000, 1);
                }, 150);
            }).triggerHandler('resize.cb.main');
        }

        // Add 'side-trans-enabled' class to #page-container (enables sidebar and side overlay transition on open/close)
        // Fixes IE10, IE11 and Edge bug in which animation was executed on each page load - really annoying!
        lPage.addClass('side-trans-enabled');
    };

    // Handles header related classes
    var uiHandleHeader = function() {
        // Unbind event in case it is already enabled
        jQuery(window).off('scroll.cb.header');

        // If the header is fixed and has the glass style, add the related class on scrolling to add a background color to the header
        if (lPage.hasClass('page-header-glass') && lPage.hasClass('page-header-fixed')) {
            jQuery(window).on('scroll.cb.header', function(){
                if (jQuery(this).scrollTop() > 60) {
                    lPage.addClass('page-header-scroll');
                } else {
                    lPage.removeClass('page-header-scroll');
                }
            }).trigger('scroll.cb.header');
        }
    };

    // Main navigation functionality
    var uiHandleNav = function() {
        // Unbind event in case it is already enabled
        lPage.off('click.cb.menu');

        // When a submenu link is clicked
        lPage.on('click.cb.menu', '[data-toggle="nav-submenu"]', function(e){
            // Get link
            var link = jQuery(this);

            // Get link's parent
            var parentLi = link.parent('li');

            if (parentLi.hasClass('open')) { // If submenu is open, close it..
                parentLi.removeClass('open');
            } else { // .. else if submenu is closed, close all other (same level) submenus first before open it
                link
                    .closest('ul')
                    .children('li')
                    .removeClass('open');

                parentLi
                    .addClass('open');
            }

            // Remove focus from submenu link
            if (lHtml.hasClass('no-focus')) {
                link.blur();
            }

            return false;
        });
    };

    // Material form inputs functionality
    var uiHandleForms = function() {
        jQuery('.form-material.floating > .form-control').each(function(){
            var input  = jQuery(this);
            var parent = input.parent('.form-material');

            setTimeout(function() {
                if (input.val() ) {
                    parent.addClass('open');
                }
            }, 150);

            input.off('change.cb.inputs').on('change.cb.inputs', function(){
                if (input.val()) {
                    parent.addClass('open');
                } else {
                    parent.removeClass('open');
                }
            });
        });
    };

    // Set active color theme functionality
    var uiHandleTheme = function() {
        var themeEl = jQuery('#css-theme');
        var cookies = lPage.hasClass('enable-cookies') ? true : false;

        // If cookies are enabled
        if (cookies) {
            var themeName  = Cookies.get('cbThemeName') || false;

            // Update color theme
            if (themeName) {
                uiHandleThemeChange(themeEl, themeName);
            }

            // Update theme element
            themeEl = jQuery('#css-theme');
        }

        // Set the active color theme link as active
        jQuery('[data-toggle="theme"][data-theme="' + (themeEl.length ? themeEl.attr('href') : 'default') + '"]')
            .parent('li')
            .addClass('active');

        // Unbind event in case it is already enabled
        lPage.off('click.cb.themes');

        // When a color theme link is clicked
        lPage.on('click.cb.themes', '[data-toggle="theme"]', function(){
            var themeName = jQuery(this).data('theme');

            // Set this color theme link as active
            jQuery('[data-toggle="theme"]')
                .parent('li')
                .removeClass('active');

            jQuery('[data-toggle="theme"][data-theme="' + themeName + '"]')
                .parent('li')
                .addClass('active');

            // Update color theme
            uiHandleThemeChange(themeEl, themeName);

            // Update theme element
            themeEl = jQuery('#css-theme');

            // If cookies are enabled, save the new active color theme
            if (cookies) {
                Cookies.set('cbThemeName', themeName, { expires: 7 });
            }
        });
    };

    // Helper function for changing a theme
    var uiHandleThemeChange = function(themeEl, themeName) {
        if (themeName === 'default') {
            if (themeEl.length) {
                themeEl.remove();
            }
        } else {
            if (themeEl.length) {
                themeEl.attr('href', themeName);
            } else {
                jQuery('#css-main')
                    .after('<link rel="stylesheet" id="css-theme" href="' + themeName + '">');
            }
        }
    };

    /*
     ********************************************************************************************
     *
     * API
     *
     * Functions which handle requests for blocks and layout
     *
     *********************************************************************************************
     */

    // Layout API
    var uiApiLayout = function(mode) {
        windowW = getWidth();

        // Mode selection
        switch(mode) {
            case 'init':
                // Unbind event in case it is already enabled
                lPage.off('click.cb.layout');

                // Call layout API on button click
                lPage.on('click.cb.layout', '[data-toggle="layout"]', function(){
                    var el = jQuery(this);

                    uiApiLayout(el.data('action'));

                    if (lHtml.hasClass('no-focus')) {
                        el.blur();
                    }
                });

                // Prepend Page Overlay div if enabled (used when Side Overlay opens)
                if (lPage.hasClass('enable-page-overlay')) {
                    lPage.prepend('<div id="page-overlay"></div>');

                    jQuery('#page-overlay').on('click.pixelcave.overlay', function(e) {
                        uiApiLayout('side_overlay_close');
                    });
                }
                break;
            case 'sidebar_pos_toggle':
                lPage.toggleClass('sidebar-r');
                break;
            case 'sidebar_pos_left':
                lPage.removeClass('sidebar-r');
                break;
            case 'sidebar_pos_right':
                lPage.addClass('sidebar-r');
                break;
            case 'sidebar_toggle':
                if (windowW > 991) {
                    lPage.toggleClass('sidebar-o');
                } else {
                    lPage.toggleClass('sidebar-o-xs');
                }
                break;
            case 'sidebar_open':
                if (windowW > 991) {
                    lPage.addClass('sidebar-o');
                } else {
                    lPage.addClass('sidebar-o-xs');
                }
                break;
            case 'sidebar_close':
                if (windowW > 991) {
                    lPage.removeClass('sidebar-o');
                } else {
                    lPage.removeClass('sidebar-o-xs');
                }
                break;
            case 'sidebar_mini_toggle':
                if (windowW > 991) {
                    lPage.toggleClass('sidebar-mini');
                }
                break;
            case 'sidebar_mini_on':
                if (windowW > 991) {
                    lPage.addClass('sidebar-mini');
                }
                break;
            case 'sidebar_mini_off':
                if (windowW > 991) {
                    lPage.removeClass('sidebar-mini');
                }
                break;
            case 'sidebar_style_inverse_toggle':
                lPage.toggleClass('sidebar-inverse');
                break;
            case 'sidebar_style_inverse_on':
                lPage.addClass('sidebar-inverse');
                break;
            case 'sidebar_style_inverse_off':
                lPage.removeClass('sidebar-inverse');
                break;
            case 'side_overlay_toggle':
               if (lPage.hasClass('side-overlay-o')) {
                   uiApiLayout('side_overlay_close');
               } else {
                   uiApiLayout('side_overlay_open');
               }
                break;
            case 'side_overlay_open':
                // When ESCAPE key is hit close the side overlay
                jQuery(document).on('keydown.cb.sideOverlay', function(e){
                    if (e.which === 27) {
                        e.preventDefault();
                        uiApiLayout('side_overlay_close');
                    }
                });

                lPage.addClass('side-overlay-o');
                break;
            case 'side_overlay_close':
                // Unbind ESCAPE key
                jQuery(document).off('keydown.cb.sideOverlay');

                lPage.removeClass('side-overlay-o');
                break;
            case 'side_overlay_hoverable_toggle':
                lPage.toggleClass('side-overlay-hover');
                break;
            case 'side_overlay_hoverable_on':
                lPage.addClass('side-overlay-hover');
                break;
            case 'side_overlay_hoverable_off':
                lPage.removeClass('side-overlay-hover');
                break;
            case 'header_fixed_toggle':
                lPage.toggleClass('page-header-fixed');
                uiHandleHeader();
                uiHandleMain();
                break;
            case 'header_fixed_on':
                lPage.addClass('page-header-fixed');
                uiHandleHeader();
                uiHandleMain();
                break;
            case 'header_fixed_off':
                lPage.removeClass('page-header-fixed');
                uiHandleHeader();
                uiHandleMain();
                break;
            case 'header_style_modern':
                lPage.removeClass('page-header-glass page-header-inverse').addClass('page-header-modern');
                uiHandleHeader();
                uiHandleMain();
                break;
            case 'header_style_classic':
                lPage.removeClass('page-header-glass page-header-modern');
                uiHandleHeader();
                uiHandleMain();
                break;
            case 'header_style_glass':
                lPage.removeClass('page-header-modern').addClass('page-header-glass');
                uiHandleHeader();
                uiHandleMain();
                break;
            case 'header_style_inverse_toggle':
                if (!lPage.hasClass('page-header-modern')) {
                    lPage.toggleClass('page-header-inverse');
                }
                break;
            case 'header_style_inverse_on':
                if (!lPage.hasClass('page-header-modern')) {
                    lPage.addClass('page-header-inverse');
                }
                break;
            case 'header_style_inverse_off':
                if (!lPage.hasClass('page-header-modern')) {
                    lPage.removeClass('page-header-inverse');
                }
                break;
            case 'header_search_on':
                lHeaderSearch.addClass('show');
                lHeaderSearchInput.focus();

                // When ESCAPE key is hit close the search section
                jQuery(document).on('keydown.cb.header.search', function(e){
                    if (e.which === 27) {
                        e.preventDefault();
                        console.log('test');
                        uiApiLayout('header_search_off');
                    }
                });
                break;
            case 'header_search_off':
                lHeaderSearch.removeClass('show');
                lHeaderSearchInput.blur();

                // Unbind ESCAPE key
                jQuery(document).off('keydown.cb.header.search');
                break;
            case 'header_loader_on':
                lHeaderLoader.addClass('show');
                break;
            case 'header_loader_off':
                lHeaderLoader.removeClass('show');
                break;
            case 'side_scroll_toggle':
                lPage.toggleClass('side-scroll');
                uiHandleScroll();
                break;
            case 'side_scroll_on':
                lPage.addClass('side-scroll');
                uiHandleScroll();
                break;
            case 'side_scroll_off':
                lPage.removeClass('side-scroll');
                uiHandleScroll();
                break;
            case 'content_layout_toggle':
                if (lPage.hasClass('main-content-boxed')) {
                    uiApiLayout('content_layout_narrow');
                } else if (lPage.hasClass('main-content-narrow')) {
                    uiApiLayout('content_layout_full_width');
                } else {
                    uiApiLayout('content_layout_boxed');
                }
                break;
            case 'content_layout_boxed':
                lPage.removeClass('main-content-narrow').addClass('main-content-boxed');
                break;
            case 'content_layout_narrow':
                lPage.removeClass('main-content-boxed').addClass('main-content-narrow');
                break;
            case 'content_layout_full_width':
                lPage.removeClass('main-content-boxed main-content-narrow');
            default:
                return false;
        }
    };

    // Blocks API
    var uiApiBlocks = function(block, mode) {
        // Set default icons for fullscreen and content toggle buttons
        var iconFullscreen         = 'si si-size-fullscreen';
        var iconFullscreenActive   = 'si si-size-actual';
        var iconContent            = 'si si-arrow-up';
        var iconContentActive      = 'si si-arrow-down';

        if (mode === 'init') {
            // Auto add the default toggle icons to fullscreen and content toggle buttons
            jQuery('[data-toggle="block-option"][data-action="fullscreen_toggle"]').each(function(){
                var el = jQuery(this);

                el.html('<i class="' + (jQuery(el).closest('.block').hasClass('block-mode-fullscreen') ? iconFullscreenActive : iconFullscreen) + '"></i>');
            });

            jQuery('[data-toggle="block-option"][data-action="content_toggle"]').each(function(){
                var el = jQuery(this);

                el.html('<i class="' + (el.closest('.block').hasClass('block-mode-hidden') ? iconContentActive : iconContent) + '"></i>');
            });

            // Unbind event in case it is already enabled
            lPage.off('click.cb.blocks');

            // Call blocks API on option button click
            lPage.on('click.cb.blocks', '[data-toggle="block-option"]', function(){
                uiApiBlocks(jQuery(this).closest('.block'), jQuery(this).data('action'));
            });
        } else {
            // Get block element
            var elBlock = (block instanceof jQuery) ? block : jQuery(block);

            // If element exists, procceed with blocks functionality
            if (elBlock.length) {
                // Get block option buttons if exist (need them to update their icons)
                var btnFullscreen       = jQuery('[data-toggle="block-option"][data-action="fullscreen_toggle"]', elBlock);
                var btnContentToggle    = jQuery('[data-toggle="block-option"][data-action="content_toggle"]', elBlock);

                // Mode selection
                switch(mode) {
                    case 'fullscreen_toggle':
                        elBlock.removeClass('block-mode-pinned').toggleClass('block-mode-fullscreen');

                        // Enable/disable scroll lock to block
                        if (elBlock.hasClass('block-mode-fullscreen')) {
                            jQuery(elBlock).scrollLock('enable');
                        } else {
                            jQuery(elBlock).scrollLock('disable');
                        }

                        // Update block option icon
                        if (btnFullscreen.length) {
                            if (elBlock.hasClass('block-mode-fullscreen')) {
                                jQuery('i', btnFullscreen)
                                    .removeClass(iconFullscreen)
                                    .addClass(iconFullscreenActive);
                            } else {
                                jQuery('i', btnFullscreen)
                                    .removeClass(iconFullscreenActive)
                                    .addClass(iconFullscreen);
                            }
                        }
                        break;
                    case 'fullscreen_on':
                        elBlock.removeClass('block-mode-pinned').addClass('block-mode-fullscreen');

                        // Enable scroll lock to block
                        jQuery(elBlock).scrollLock('enable');

                        // Update block option icon
                        if (btnFullscreen.length) {
                            jQuery('i', btnFullscreen)
                                .removeClass(iconFullscreen)
                                .addClass(iconFullscreenActive);
                        }
                        break;
                    case 'fullscreen_off':
                        elBlock.removeClass('block-mode-fullscreen');

                        // Disable scroll lock to block
                        jQuery(elBlock).scrollLock('disable');

                        // Update block option icon
                        if (btnFullscreen.length) {
                            jQuery('i', btnFullscreen)
                                .removeClass(iconFullscreenActive)
                                .addClass(iconFullscreen);
                        }
                        break;
                    case 'content_toggle':
                        elBlock.toggleClass('block-mode-hidden');

                        // Update block option icon
                        if (btnContentToggle.length) {
                            if (elBlock.hasClass('block-mode-hidden')) {
                                jQuery('i', btnContentToggle)
                                    .removeClass(iconContent)
                                    .addClass(iconContentActive);
                            } else {
                                jQuery('i', btnContentToggle)
                                    .removeClass(iconContentActive)
                                    .addClass(iconContent);
                            }
                        }
                        break;
                    case 'content_hide':
                        elBlock.addClass('block-mode-hidden');

                        // Update block option icon
                        if (btnContentToggle.length) {
                            jQuery('i', btnContentToggle)
                                .removeClass(iconContent)
                                .addClass(iconContentActive);
                        }
                        break;
                    case 'content_show':
                        elBlock.removeClass('block-mode-hidden');

                        // Update block option icon
                        if (btnContentToggle.length) {
                            jQuery('i', btnContentToggle)
                                .removeClass(iconContentActive)
                                .addClass(iconContent);
                        }
                        break;
                    case 'state_toggle':
                        elBlock.toggleClass('block-mode-loading');

                        // Return block to normal state if the demostration mode is on in the refresh option button - data-action-mode="demo"
                        if (jQuery('[data-toggle="block-option"][data-action="state_toggle"][data-action-mode="demo"]', elBlock).length) {
                            setTimeout(function(){
                                elBlock.removeClass('block-mode-loading');
                            }, 2000);
                        }
                        break;
                    case 'state_loading':
                        elBlock.addClass('block-mode-loading');
                        break;
                    case 'state_normal':
                        elBlock.removeClass('block-mode-loading');
                        break;
                    case 'pinned_toggle':
                        elBlock.removeClass('block-mode-fullscreen').toggleClass('block-mode-pinned');
                        break;
                    case 'pinned_on':
                        elBlock.removeClass('block-mode-fullscreen').addClass('block-mode-pinned');
                        break;
                    case 'pinned_off':
                        elBlock.removeClass('block-mode-pinned');
                        break;
                    case 'close':
                        elBlock.hide();
                        break;
                    case 'open':
                        elBlock.show();
                        break;
                    default:
                        return false;
                }
            }
        }
    };

    /*
     ********************************************************************************************
     *
     * PRIVATE HELPERS
     *
     * Private helper functions
     *
     *********************************************************************************************
     */

    // Get window width
    var getWidth = function() {
        return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    };

    /*
     ********************************************************************************************
     *
     * CORE HELPERS
     *
     * Third party plugin inits or various custom user interface helpers to extend functionality
     * They are called by default and can be used right away
     *
     *********************************************************************************************
     */

    // Toggle class
    var uiHelperCoreToggleClass = function() {
        jQuery('[data-toggle="class-toggle"]:not(.js-class-toggle-enabled)').on('click.cb.helpers.core', function(){
            var el = jQuery(this);

            // Add .js-class-toggle-enabled class to tag it as activated
            el.addClass('js-class-toggle-enabled');

            jQuery(el.data('target').toString()).toggleClass(el.data('class').toString());

            if (lHtml.hasClass('no-focus')) {
                el.blur();
            }
        });
    };

    // Scroll to element animation
    var uiHelperCoreScrollTo = function() {
        jQuery('[data-toggle="scroll-to"]:not(.js-scroll-to-enabled)').on('click.cb.helpers.core', function(e){
            e.stopPropagation();

            // Set variables
            var el            = jQuery(this);
            var elTarget      = el.data('target') || el.attr('href');
            var elSpeed       = el.data('speed') || 1000;
            var headerHeight  = (lHeader.length && lPage.hasClass('page-header-fixed')) ? lHeader.outerHeight() : 0;

            // Add .js-scroll-to-enabled class to tag it as activated
            el.addClass('js-scroll-to-enabled');

            jQuery('html, body').animate({
                scrollTop: jQuery(elTarget).offset().top - headerHeight
            }, elSpeed);
        });
    };

    // Add the correct copyright year
    var uiHelperCoreYearCopy = function() {
        var yearCopy = jQuery('.js-year-copy');

        if (yearCopy.length > 0) {
            var date        = new Date();
            var curYear     = date.getFullYear();
            var baseYear    = (yearCopy.html().length > 0) ? yearCopy.html() : curYear;

            if (parseInt(baseYear) >= curYear) {
                yearCopy.html(curYear);
            } else {
                yearCopy.html(baseYear + '-' + curYear.toString().substr(2, 2));
            }
        }
    };

    // Bootstrap tooltip, for more examples you can check out https://getbootstrap.com/docs/4.1/components/tooltips/
    var uiHelperCoreTooltip = function() {
        jQuery('[data-toggle="tooltip"]:not(.js-tooltip-enabled)').add('.js-tooltip:not(.js-tooltip-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-tooltip-enabled class to tag it as activated
            el.addClass('js-tooltip-enabled');

            // Init
            el.tooltip({
                container: el.data('container') || 'body',
                animation: el.data('animation') || false
            });
        });
    };

    // Bootstrap popover, for more examples you can check out https://getbootstrap.com/docs/4.1/components/popovers/
    var uiHelperCorePopover = function() {
        jQuery('[data-toggle="popover"]:not(.js-popover-enabled)').add('.js-popover:not(.js-popover-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-popover-enabled class to tag it as activated
            el.addClass('js-popover-enabled');

            // Init
            el.popover({
                container: el.data('container') || 'body',
                animation: el.data('animation') || false,
                trigger: el.data('trigger') || 'hover focus'
            });
        });
    };

    // Bootstrap tab, for more examples you can check out http://getbootstrap.com/docs/4.0/components/navs/#tabs
    var uiHelperCoreTab = function() {
        jQuery('[data-toggle="tabs"]:not(.js-tabs-enabled)').add('.js-tabs:not(.js-tabs-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-tabs-enabled class to tag it as activated
            el.addClass('js-tabs-enabled');

            // Init
            el.find('a').on('click.cb.helpers.core', function(e){
                e.preventDefault();
                jQuery(this).tab('show');
            });
        });
    };

    // jQuery Appear, for more examples you can check out https://github.com/bas2k/jquery.appear
    var uiHelperCoreAppear = function(){
        // Add a specific class on elements (when they become visible on scrolling)
        jQuery('[data-toggle="appear"]:not(.js-appear-enabled)').each(function(){
            windowW = getWidth();

            var el         = jQuery(this);
            var elCssClass = el.data('class') || 'animated fadeIn';
            var elOffset   = el.data('offset') || 0;
            var elTimeout  = (lHtml.hasClass('ie9') || windowW < 992) ? 0 : (el.data('timeout') ? el.data('timeout') : 0);

            // Add .js-appear-enabled class to tag it as activated
            el.addClass('js-appear-enabled');

            // Init
            el.appear(function() {
                setTimeout(function(){
                    el
                        .removeClass('invisible')
                        .addClass(elCssClass);
                }, elTimeout);
            },{accY: elOffset});
        });
    };

    // jQuery Appear + jQuery countTo, for more examples you can check out https://github.com/bas2k/jquery.appear and https://github.com/mhuggins/jquery-countTo
    var uiHelperCoreAppearCountTo = function(){
        // Init counter functionality
        jQuery('[data-toggle="countTo"]:not(.js-count-to-enabled)').each(function(){
            var el         = jQuery(this);
            var elAfter    = el.data('after');
            var elBefore   = el.data('before');

            // Add .js-count-to-enabled class to tag it as activated
            el.addClass('js-count-to-enabled');

            // Init
            el.appear(function() {
                el.countTo({
                    speed: el.data('speed') || 1500,
                    refreshInterval: el.data('refresh-interval') || 15,
                    onComplete: function() {
                        if(elAfter) {
                            el.html(el.html() + elAfter);
                        } else if (elBefore) {
                            el.html(elBefore + el.html());
                        }
                    }
                });
            });
        });
    };

    // jQuery SlimScroll, for more examples you can check out http://rocha.la/jQuery-slimScroll
    var uiHelperCoreSlimscroll = function(){
        // Init slimScroll functionality
        jQuery('[data-toggle="slimscroll"]:not(.js-slimscroll-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-slimscroll-enabled class to tag it as activated
            el.addClass('js-slimscroll-enabled');

            // Init
            el.slimScroll({
                height: el.data('height') || '200px',
                size: el.data('size') || '5px',
                position: el.data('position') || 'right',
                color: el.data('color') || '#000',
                opacity: el.data('opacity') || '.25',
                distance: el.data('distance') || '0',
                alwaysVisible: el.data('always-visible') ? true : false,
                railVisible: el.data('rail-visible') ? true : false,
                railColor: el.data('rail-color') ||'#999',
                railOpacity: el.data('rail-opacity') || .3
            });
        });
    };

    // Manage page loading screen functionality
    var uiHelperCorePageLoader = function(mode, colorClass) {
        var lpageLoader = jQuery('#page-loader');

        if (mode === 'show') {
            if (lpageLoader.length) {
                if (colorClass) {
                    lpageLoader.removeClass().addClass(colorClass);
                }

                lpageLoader.addClass('show');
            } else {
                if (colorClass) {
                    lBody.prepend('<div id="page-loader" class="show ' + colorClass + '"></div>');
                } else {
                    lBody.prepend('<div id="page-loader" class="show"></div>');
                }
            }
        } else if (mode === 'hide') {
            if (lpageLoader.length) {
                lpageLoader.removeClass('show');
            }
        }

        return false;
    };

    // Ripple effect fuctionality
    var uiHelperCoreRipple = function() {
        jQuery('[data-toggle="click-ripple"]:not(.js-click-ripple-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-click-ripple-enabled class to tag it as activated
            el.addClass('js-click-ripple-enabled');

            // Add required properties to the element
            el.css({
                'overflow': 'hidden',
                'position': 'relative',
                'z-index': 1
            });

            // On element click
            el.on('click.cb.helpers.core', function(e) {
                var cssClass = 'click-ripple', ripple, d, x, y;

                // If the ripple element doesn't exist in this element, add it..
                if (el.children('.' + cssClass).length === 0) {
                    el.prepend('<span class="' + cssClass + '"></span>');
                }
                else { // ..else remove .animate class from ripple element
                    el.children('.' + cssClass).removeClass('animate');
                }

                // Get the ripple element
                var ripple = el.children('.' + cssClass);

                // If the ripple element doesn't have dimensions set them accordingly
                if(!ripple.height() && !ripple.width()) {
                    d = Math.max(el.outerWidth(), el.outerHeight());
                    ripple.css({height: d, width: d});
                }

                // Get coordinates for our ripple element
                x = e.pageX - el.offset().left - ripple.width()/2;
                y = e.pageY - el.offset().top - ripple.height()/2;

                // Position the ripple element and add the class .animate to it
                ripple.css({top: y + 'px', left: x + 'px'}).addClass('animate');
            });
        });
    };

    // Bootstrap Custom File Input Filename
    var uiHelperCoreCustomFileInput = function() {
        // Populate custom Bootstrap file inputs with selected filename
        jQuery('[data-toggle="custom-file-input"]:not(.js-custom-file-input-enabled)').each(function(index, element) {
            var el = jQuery(element);

            // Add .js-custom-file-input-enabled class to tag it as activated
            el.addClass('js-custom-file-input-enabled').on('change', function(e) {
                var fileName = (e.target.files.length > 1) ? e.target.files.length + ' ' + (el.data('lang-files') || 'Files') : e.target.files[0].name;

                el.next('.custom-file-label').css('overflow-x', 'hidden').html(fileName);
            });
        });
    };

    /*
     ********************************************************************************************
     *
     * UI HELPERS (ON DEMAND)
     *
     * Third party plugin inits or various custom user interface helpers to extend functionality
     * They need to be called in a page to be initialized. They are included here to be easy to
     * init them on demand on multiple pages (usually repeated init code in common components)
     *
     ********************************************************************************************
     */

    /*
     * Print Page functionality
     *
     * Codebase.helper('print-page');
     *
     */
    var uiHelperPrint = function() {
        // Store all #page-container classes
        var pageCls = lPage.prop('class');

        // Remove all classes from #page-container
        lPage.prop('class', '');

        // Print the page
        window.print();

        // Restore all #page-container classes
        lPage.prop('class', pageCls);
    };

    /*
     * Custom Table functionality such as section toggling or checkable rows
     *
     * Codebase.helper('table-tools');
     *
     */

    // Table sections functionality
    var uiHelperTableToolsSections = function(){
        // For each table
        jQuery('.js-table-sections:not(.js-table-sections-enabled)').each(function(){
            var table = jQuery(this);

            // Add .js-table-sections-enabled class to tag it as activated
            table.addClass('js-table-sections-enabled');

            // When a row is clicked in tbody.js-table-sections-header
            jQuery('.js-table-sections-header > tr', table).on('click.cb.helpers', function(e) {
                if (e.target.type !== 'checkbox'
                        && e.target.type !== 'button'
                        && e.target.tagName.toLowerCase() !== 'a'
                        && !jQuery(e.target).parent('a').length
                        && !jQuery(e.target).parent('button').length
                        && !jQuery(e.target).parent('.custom-control').length
                        && !jQuery(e.target).parent('label').length) {
                    var row    = jQuery(this);
                    var tbody  = row.parent('tbody');

                    if ( ! tbody.hasClass('show')) {
                        jQuery('tbody', table).removeClass('show table-active');
                    }

                    tbody.toggleClass('show table-active');
                }
            });
        });
    };

    // Checkable table functionality
    var uiHelperTableToolsCheckable = function() {
        // For each table
        jQuery('.js-table-checkable:not(.js-table-checkable-enabled)').each(function(){
            var table = jQuery(this);

            // Add .js-table-checkable-enabled class to tag it as activated
            table.addClass('js-table-checkable-enabled');

            // When a checkbox is clicked in thead
            jQuery('thead input:checkbox', table).on('click.cb.helpers', function() {
                var checkedStatus = jQuery(this).prop('checked');

                // Check or uncheck all checkboxes in tbody
                jQuery('tbody input:checkbox', table).each(function() {
                    var checkbox = jQuery(this);

                    checkbox.prop('checked', checkedStatus);
                    uiHelperTableToolscheckRow(checkbox, checkedStatus);
                });
            });

            // When a checkbox is clicked in tbody
            jQuery('tbody input:checkbox', table).on('click.cb.helpers', function() {
                var checkbox = jQuery(this);

                uiHelperTableToolscheckRow(checkbox, checkbox.prop('checked'));
            });

            // When a row is clicked in tbody
            jQuery('tbody > tr', table).on('click.cb.helpers', function(e) {
                if (e.target.type !== 'checkbox'
                        && e.target.type !== 'button'
                        && e.target.tagName.toLowerCase() !== 'a'
                        && !jQuery(e.target).parent('a').length
                        && !jQuery(e.target).parent('button').length
                        && !jQuery(e.target).parent('.custom-control').length
                        && !jQuery(e.target).parent('label').length) {
                    var checkbox       = jQuery('input:checkbox', this);
                    var checkedStatus  = checkbox.prop('checked');

                    checkbox.prop('checked', ! checkedStatus);
                    uiHelperTableToolscheckRow(checkbox, ! checkedStatus);
                }
            });
        });
    };

    // Checkable table functionality helper - Checks or unchecks table row
    var uiHelperTableToolscheckRow = function(checkbox, checkedStatus) {
        if (checkedStatus) {
            checkbox
                .closest('tr')
                .addClass('table-active');
        } else {
            checkbox
                .closest('tr')
                .removeClass('table-active');
        }
    };

    /*
     * Content filtering functionality
     *
     * Codebase.helper('content-filter');
     *
     */
    var uiHelperContentFilter = function() {
        // Content Filtering init
        jQuery('.js-filter:not(.js-filter-enabled)').each(function(){
            var el          = jQuery(this);
            var filterNav   = jQuery('.nav-pills', el);
            var filterLinks = jQuery('a[data-category-link]', el);
            var filterItems = jQuery('[data-category]', el);
            var filterSpeed = el.data('speed') || 200;

            // Add .js-filter-enabled class to tag it as activated
            el.addClass('js-filter-enabled');

            // If navigation pills are used, make them responsive (stacked on smaller screens)
            if (filterNav.length) {
                var resizeTimeout, windowW;

                jQuery(window).on('resize.cb.helpers', function(){
                    clearTimeout(resizeTimeout);

                    resizeTimeout = setTimeout(function(){
                        windowW = getWidth();

                        if (windowW < 768) {
                            filterNav.addClass('flex-column');
                        } else {
                            filterNav.removeClass('flex-column');
                        }
                    }, 150);
                }).trigger('resize.cb.helpers');
            }

            // Add number of items to the links if enabled by adding data-numbers="true" to the main element
            if (el.data('numbers')) {
                filterLinks.each(function(){
                    var filterLink  = jQuery(this);
                    var filterCat   = filterLink.data('category-link');

                    // Add number of items to this category link
                    if (filterCat === 'all') {
                        filterLink.append(' (' + filterItems.length + ')');
                    } else {
                        filterLink.append(' (' + filterItems.filter('[data-category="' + filterCat + '"]').length + ')');
                    }
                });
            }

            // When a filter link is clicked
            filterLinks.on('click.cb.helpers', function() {
                var filterLink = jQuery(this);
                var filterCat;

                // Procceed only if the user clicked on an inactive category
                if ( ! filterLink.hasClass('active')) {
                    // Remove active class from all filter links
                    filterLinks.removeClass('active');

                    // Add the active class to the clicked link
                    filterLink.addClass('active');

                    // Get its data-category value
                    filterCat = filterLink.data('category-link');

                    // If the value is 'all' hide current visible items and show them all together, else hide them all and show only from the category we need
                    if (filterCat === 'all') {
                        if (filterItems.filter(':visible').length) {
                            filterItems.filter(':visible').fadeOut(filterSpeed, function(){
                                filterItems.fadeIn(filterSpeed);
                            });
                        } else {
                            filterItems.fadeIn(filterSpeed);
                        }
                    } else {
                        if (filterItems.filter(':visible').length) {
                            filterItems.filter(':visible').fadeOut(filterSpeed, function(){
                                filterItems
                                    .filter('[data-category="' + filterCat + '"]')
                                    .fadeIn(filterSpeed);
                            });
                        } else {
                            filterItems
                                .filter('[data-category="' + filterCat + '"]')
                                .fadeIn(filterSpeed);
                        }
                    }
                }

                return false;
            });
        });
    };

    /*
     ********************************************************************************************
     *
     * All the following helpers require each plugin's resources (JS, CSS) to be included in order to work
     *
     ********************************************************************************************
     */

    /*
     * Magnific Popup functionality, for more examples you can check out http://dimsemenov.com/plugins/magnific-popup/
     *
     * Codebase.helper('magnific-popup');
     *
     */
    var uiHelperMagnific = function(){
        // Gallery init
        jQuery('.js-gallery:not(.js-gallery-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-gallery-enabled class to tag it as activated
            el.addClass('js-gallery-enabled');

            // Init
            el.magnificPopup({
                delegate: 'a.img-lightbox',
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });
    };

    /*
     * CKEditor init, for more examples you can check out http://ckeditor.com/
     *
     * Codebase.helper('ckeditor');
     *
     */
    var uiHelperCkeditor = function(){
        // Init inline text editor
        if (jQuery('#js-ckeditor-inline:not(.js-ckeditor-inline-enabled)').length) {
            jQuery('#js-ckeditor-inline').attr('contenteditable','true');
            CKEDITOR.inline('js-ckeditor-inline');

            // Add .js-ckeditor-inline-enabled class to tag it as activated
            jQuery('#js-ckeditor-inline').addClass('js-ckeditor-inline-enabled');
        }

        // Init full text editor
        if (jQuery('#js-ckeditor:not(.js-ckeditor-enabled)').length) {
            CKEDITOR.replace('js-ckeditor');

            // Add .js-ckeditor-enabled class to tag it as activated
            jQuery('#js-ckeditor').addClass('js-ckeditor-enabled');
        }
    };

    /*
     * SimpleMDE init, for more examples you can check out https://github.com/NextStepWebs/simplemde-markdown-editor
     *
     * Codebase.helper('simplemde');
     *
     */
    var uiHelperSimpleMDE = function(){
        // Init markdown editor (with .js-simplemde class)
        jQuery('.js-simplemde:not(.js-simplemde-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-simplemde-enabled class to tag it as activated
            el.addClass('js-simplemde-enabled');

            // Init editor
            new SimpleMDE({ element: el[0] });
        });
    };

    /*
     * Slick init, for more examples you can check out http://kenwheeler.github.io/slick/
     *
     * Codebase.helper('slick');
     *
     */
    var uiHelperSlick = function(){
        // Get each slider element (with .js-slider class)
        jQuery('.js-slider:not(.js-slider-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-slider-enabled class to tag it as activated
            el.addClass('js-slider-enabled');

            // Init slick slider
            el.slick({
                arrows: el.data('arrows') || false,
                dots: el.data('dots') || false,
                slidesToShow: el.data('slides-to-show') || 1,
                slidesToScroll: el.data('slides-to-scroll') || 1,
                centerMode: el.data('center-mode') || false,
                autoplay: el.data('autoplay') || false,
                autoplaySpeed: el.data('autoplay-speed') || 3000,
                infinite: typeof el.data('infinite') === 'undefined' ? true : el.data('infinite')
            });
        });
    };

    /*
     * Bootstrap Datepicker init, for more examples you can check out https://github.com/eternicode/bootstrap-datepicker
     *
     * Codebase.helper('datepicker');
     *
     */
    var uiHelperDatepicker = function(){
        // Init datepicker (with .js-datepicker and .input-daterange class)
        jQuery('.js-datepicker:not(.js-datepicker-enabled)').add('.input-daterange:not(.js-datepicker-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-datepicker-enabled class to tag it as activated
            el.addClass('js-datepicker-enabled');

            // Init
            el.datepicker({
                weekStart: el.data('week-start') || 0,
                autoclose: el.data('autoclose') || false,
                todayHighlight: el.data('today-highlight') || false,
                orientation: 'bottom' // Position issue when using BS4, set it to bottom until officially supported
            });
        });
    };

    /*
     * Bootstrap Colorpicker init, for more examples you can check out https://github.com/itsjavi/bootstrap-colorpicker/
     *
     * Codebase.helper('colorpicker');
     *
     */
    var uiHelperColorpicker = function(){
        // Get each colorpicker element (with .js-colorpicker class)
        jQuery('.js-colorpicker:not(.js-colorpicker-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-enabled class to tag it as activated
            el.addClass('js-colorpicker-enabled');

            // Init colorpicker
            el.colorpicker();
        });
    };

    /*
     * Masked Inputs, for more examples you can check out http://digitalbush.com/projects/masked-input-plugin/
     *
     * Codebase.helper('masked-inputs');
     *
     */
    var uiHelperMaskedInputs = function(){
        // Init Masked Inputs
        // a - Represents an alpha character (A-Z,a-z)
        // 9 - Represents a numeric character (0-9)
        // * - Represents an alphanumeric character (A-Z,a-z,0-9)
        jQuery('.js-masked-date:not(.js-masked-enabled)').mask('99/99/9999');
        jQuery('.js-masked-date-dash:not(.js-masked-enabled)').mask('99-99-9999');
        jQuery('.js-masked-phone:not(.js-masked-enabled)').mask('(999) 999-9999');
        jQuery('.js-masked-phone-ext:not(.js-masked-enabled)').mask('(999) 999-9999? x99999');
        jQuery('.js-masked-taxid:not(.js-masked-enabled)').mask('99-9999999');
        jQuery('.js-masked-ssn:not(.js-masked-enabled)').mask('999-99-9999');
        jQuery('.js-masked-pkey:not(.js-masked-enabled)').mask('a*-999-a999');
        jQuery('.js-masked-time:not(.js-masked-enabled)').mask('99:99');

        jQuery('.js-masked-date')
            .add('.js-masked-date-dash')
            .add('.js-masked-phone')
            .add('.js-masked-phone-ext')
            .add('.js-masked-taxid')
            .add('.js-masked-ssn')
            .add('.js-masked-pkey')
            .add('.js-masked-time')
            .addClass('js-masked-enabled');
    };

    /*
     * Tags Inputs, for more examples you can check out https://github.com/xoxco/jQuery-Tags-Input
     *
     * Codebase.helper('tags-inputs');
     *
     */
    var uiHelperTagsInputs = function(){
        // Init Tags Inputs (with .js-tags-input class)
        jQuery('.js-tags-input:not(.js-tags-input-enabled)').each(function(){
           var el = jQuery(this);

            // Add .js-tags-input-enabled class to tag it as activated
            el.addClass('js-tags-input-enabled');

            // Init
            el.tagsInput({
                height: el.data('height') || false,
                width: el.data('width') || '100%',
                defaultText: el.data('default-text') || 'Add tag',
                removeWithBackspace: el.data('remove-with-backspace') || true,
                delimiter: [',']
            });
        });
    };

    /*
     * Select2, for more examples you can check out https://github.com/select2/select2
     *
     * Codebase.helper('select2');
     *
     */
    var uiHelperSelect2 = function(){
        // Init Select2 (with .js-select2 class)
        jQuery('.js-select2:not(.js-select2-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-select2-enabled class to tag it as activated
            el.addClass('js-select2-enabled');

            // Init
            el.select2();
        });
    };

    /*
     * Highlight.js, for more examples you can check out https://highlightjs.org/usage/
     *
     * Codebase.helper('highlightjs');
     *
     */
    var uiHelperHighlightjs = function(){
        // Init Highlight.js
        if ( ! hljs.isHighlighted) {
            hljs.initHighlighting();
        }
    };

    /*
     * Bootstrap Notify, for more examples you can check out http://bootstrap-growl.remabledesigns.com/
     *
     * Codebase.helper('notify');
     *
     */
    var uiHelperNotify = function(){
        // Init notifications (with .js-notify class)
        jQuery('.js-notify:not(.js-notify-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-notify-enabled class to tag it as activated
            el.addClass('js-notify-enabled');

            // Init on click
            el.on('click.cb.helpers', function(){
                var growl = jQuery(this);

                // Create notification
                jQuery.notify({
                        icon: growl.data('icon') || '',
                        message: growl.data('message'),
                        url: growl.data('url') || ''
                    },
                    {
                        element: 'body',
                        type: growl.data('type') || 'info',
                        allow_dismiss: true,
                        newest_on_top: true,
                        showProgressbar: false,
                        placement: {
                            from: growl.data('from') || 'top',
                            align: growl.data('align') || 'right'
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 1033,
                        delay: 5000,
                        timer: 1000,
                        template: '<div data-notify="container" class="col-11 col-sm-3 alert alert-{0}" role="alert">' +
                                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                                    '<span data-notify="icon"></span> ' +
                                    '<span data-notify="title">{1}</span> ' +
                                    '<span data-notify="message">{2}</span>' +
                                    '<div class="progress" data-notify="progressbar">' +
                                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                                    '</div>' +
                                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                                    '</div>',
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOutDown'
                        }
                    });
            });
        });
    };

    /*
     * Draggable items with jQuery, for more examples you can check out https://jqueryui.com/sortable/
     *
     * Codebase.helper('draggable-items');
     *
     */
    var uiHelperDraggableItems = function(){
        // Init draggable items functionality (with .js-draggable-items class)
        jQuery('.js-draggable-items:not(.js-draggable-items-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-draggable-items-enabled class to tag it as activated
            el.addClass('js-draggable-items-enabled');

            // Init
            el.children('.draggable-column').sortable({
                connectWith: '.draggable-column',
                items: '.draggable-item',
                dropOnEmpty: true,
                opacity: .75,
                handle: '.draggable-handler',
                placeholder: 'draggable-placeholder',
                tolerance: 'pointer',
                start: function(e, ui){
                    ui.placeholder.css({
                        'height': ui.item.outerHeight(),
                        'margin-bottom': ui.item.css('margin-bottom')
                    });
                }
            });
        });
    };

    /*
     * Easy Pie Chart, for more examples you can check out http://rendro.github.io/easy-pie-chart/
     *
     * Codebase.helper('easy-pie-chart');
     *
     */
    var uiHelperEasyPieChart = function(){
        // Init Easy Pie Charts (with .js-pie-chart class)
        jQuery('.js-pie-chart:not(.js-pie-chart-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-pie-chart-enabled class to tag it as activated
            el.addClass('js-pie-chart-enabled');

            // Init
            el.easyPieChart({
                barColor: el.data('bar-color') || '#777777',
                trackColor: el.data('track-color') || '#eeeeee',
                lineWidth: el.data('line-width') || 3,
                size: el.data('size') || '80',
                animate: el.data('animate') || 750,
                scaleColor: el.data('scale-color') || false
            });
        });
    };

    /*
     * Bootstrap Maxlength, for more examples you can check out https://github.com/mimo84/bootstrap-maxlength
     *
     * Codebase.helper('maxlength');
     *
     */
    var uiHelperMaxlength = function(){
        // Init Bootstrap Maxlength (with .js-maxlength class)
        jQuery('.js-maxlength:not(.js-maxlength-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-maxlength-enabled class to tag it as activated
            el.addClass('js-maxlength-enabled');

            // Init
            el.maxlength({
                alwaysShow: el.data('always-show') ? true : false,
                threshold: el.data('threshold') || 10,
                warningClass: el.data('warning-class') || 'badge badge-warning',
                limitReachedClass: el.data('limit-reached-class') || 'badge badge-danger',
                placement: el.data('placement') || 'bottom',
                preText: el.data('pre-text') || '',
                separator: el.data('separator') || '/',
                postText: el.data('post-text') || ''
            });
        });
    };

    /*
     * Ion Range Slider, for more examples you can check out https://github.com/IonDen/ion.rangeSlider
     *
     * Codebase.helper('rangeslider');
     *
     */
    var uiHelperRangeslider = function(){
        // Init Ion Range Slider (with .js-rangeslider class)
        jQuery('.js-rangeslider:not(.js-rangeslider-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-rangeslider-enabled class to tag it as activated
            el.addClass('js-rangeslider-enabled');

            // Init
            el.ionRangeSlider({
                input_values_separator: ';'
            });
        });
    };

    /*
     * Summernote, for more examples you can check out https://github.com/summernote/summernote/
     *
     * Codebase.helper('summernote');
     *
     */
    var uiHelperSummernote = function(){
        // Init text editor in air mode (inline)
        jQuery('.js-summernote-air:not(.js-summernote-air-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-summernote-air-enabled class to tag it as activated
            el.addClass('js-summernote-air-enabled');

            // Init
            el.summernote({
                airMode: true,
                tooltip: false
            });
        });

        // Init full text editor
        jQuery('.js-summernote:not(.js-summernote-enabled)').each(function(){
            var el = jQuery(this);

            // Add .js-summernote-enabled class to tag it as activated
            el.addClass('js-summernote-enabled');

            // Init
            el.summernote({
                height: 350,
                minHeight: null,
                maxHeight: null
            });
        });
    };

    return {
        init: function() {
            // LAYOUT VARIABLES
            uiInit();

            // BASE UI
            uiHandleScroll('init');
            uiHandleMain();
            uiHandleHeader();
            uiHandleNav();
            uiHandleForms();
            uiHandleTheme();

            // API
            uiApiLayout('init');
            uiApiBlocks(false, 'init');

            // CORE HELPERS
            uiHelperCoreToggleClass();
            uiHelperCoreScrollTo();
            uiHelperCoreYearCopy();
            uiHelperCoreTooltip();
            uiHelperCorePopover();
            uiHelperCoreTab();
            uiHelperCoreAppear();
            uiHelperCoreAppearCountTo();
            uiHelperCoreSlimscroll();
            uiHelperCorePageLoader('hide');
            uiHelperCoreRipple();
            uiHelperCoreCustomFileInput();
        },
        layout: function(mode) {
            uiApiLayout(mode);
        },
        blocks: function(block, mode) {
            uiApiBlocks(block, mode);
        },
        loader: function(mode, colorClass) {
            uiHelperCorePageLoader(mode, colorClass);
        },
        helper: function(helper) {
            switch (helper) {
                case 'core-fn-uiInit':
                    uiInit();
                    break;
                case 'core-fn-uiHandleScrollInit':
                    uiHandleScroll('init');
                    break;
                case 'core-fn-uiHandleScroll':
                    uiHandleScroll();
                    break;
                case 'core-fn-uiHandleMain':
                    uiHandleMain();
                    break;
                case 'core-fn-uiHandleHeader':
                    uiHandleHeader();
                    break;
                case 'core-fn-uiHandleNav':
                    uiHandleNav();
                    break;
                case 'core-fn-uiHandleForms':
                    uiHandleForms();
                    break;
                case 'core-fn-uiHandleTheme':
                    uiHandleTheme();
                    break;
                case 'core-fn-uiApiLayout':
                    uiApiLayout('init');
                    break;
                case 'core-fn-uiApiBlocks':
                    uiApiBlocks(false, 'init');
                    break;
                case 'core-tooltip':
                    uiHelperCoreTooltip();
                    break;
                case 'core-popover':
                    uiHelperCorePopover();
                    break;
                case 'core-tab':
                    uiHelperCoreTab();
                    break;
                case 'core-scrollTo':
                    uiHelperCoreScrollTo();
                    break;
                case 'core-toggle-class':
                    uiHelperCoreToggleClass();
                    break;
                case 'core-year-copy':
                    uiHelperCoreYearCopy();
                    break;
                case 'core-appear':
                    uiHelperCoreAppear();
                    break;
                case 'core-appear-countTo':
                    uiHelperCoreAppearCountTo();
                    break;
                case 'core-slimscroll':
                    uiHelperCoreSlimscroll();
                    break;
                case 'core-ripple':
                    uiHelperCoreRipple();
                    break;
                case 'core-page-loader':
                    uiHelperCorePageLoader('hide');
                    break;
                case 'core-custom-file-input':
                    uiHelperCoreCustomFileInput();
                    break;
                case 'print-page':
                    uiHelperPrint();
                    break;
                case 'table-tools':
                    uiHelperTableToolsSections();
                    uiHelperTableToolsCheckable();
                    break;
                case 'content-filter':
                    uiHelperContentFilter();
                    break;
                case 'slimscroll':
                    uiHelperSlimscroll();
                    break;
                case 'magnific-popup':
                    uiHelperMagnific();
                    break;
                case 'ckeditor':
                    uiHelperCkeditor();
                    break;
                case 'simplemde':
                    uiHelperSimpleMDE();
                    break;
                case 'slick':
                    uiHelperSlick();
                    break;
                case 'datepicker':
                    uiHelperDatepicker();
                    break;
                case 'colorpicker':
                    uiHelperColorpicker();
                    break;
                case 'tags-inputs':
                    uiHelperTagsInputs();
                    break;
                case 'masked-inputs':
                    uiHelperMaskedInputs();
                    break;
                case 'select2':
                    uiHelperSelect2();
                    break;
                case 'highlightjs':
                    uiHelperHighlightjs();
                    break;
                case 'notify':
                    uiHelperNotify();
                    break;
                case 'draggable-items':
                    uiHelperDraggableItems();
                    break;
                case 'easy-pie-chart':
                    uiHelperEasyPieChart();
                    break;
                case 'maxlength':
                    uiHelperMaxlength();
                    break;
                case 'rangeslider':
                    uiHelperRangeslider();
                    break;
                case 'summernote':
                    uiHelperSummernote();
                    break;
                default:
                    return false;
            }
        },
        helpers: function(helpers) {
            if (helpers instanceof Array) {
                for (var index in helpers) {
                    Codebase.helper(helpers[index]);
                }
            } else {
                Codebase.helper(helpers);
            }
        }
    };
}();

// Initialize when page loads
jQuery(function(){
    if (typeof angular === 'undefined') {
        Codebase.init();
    }
});
