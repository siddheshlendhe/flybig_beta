(window.travelpayoutsWpPlugin=window.travelpayoutsWpPlugin||[]).push([[24],{610:function(e,t,n){"use strict";function r(){if(!(this instanceof r))return new r;this.size=0,this.uid=0,this.selectors=[],this.selectorObjects={},this.indexes=Object.create(this.indexes),this.activeIndexes=[]}n.d(t,"a",(function(){return F})),n.d(t,"b",(function(){return C}));var o=window.document.documentElement,i=o.matches||o.webkitMatchesSelector||o.mozMatchesSelector||o.oMatchesSelector||o.msMatchesSelector;r.prototype.matchesSelector=function(e,t){return i.call(e,t)},r.prototype.querySelectorAll=function(e,t){return t.querySelectorAll(e)},r.prototype.indexes=[];var s=/^#((?:[\w\u00c0-\uFFFF\-]|\\.)+)/g;r.prototype.indexes.push({name:"ID",selector:function(e){var t;if(t=e.match(s))return t[0].slice(1)},element:function(e){if(e.id)return[e.id]}});var a=/^\.((?:[\w\u00c0-\uFFFF\-]|\\.)+)/g;r.prototype.indexes.push({name:"CLASS",selector:function(e){var t;if(t=e.match(a))return t[0].slice(1)},element:function(e){var t=e.className;if(t){if("string"==typeof t)return t.split(/\s/);if("object"==typeof t&&"baseVal"in t)return t.baseVal.split(/\s/)}}});var c,u=/^((?:[\w\u00c0-\uFFFF\-]|\\.)+)/g;r.prototype.indexes.push({name:"TAG",selector:function(e){var t;if(t=e.match(u))return t[0].toUpperCase()},element:function(e){return[e.nodeName.toUpperCase()]}}),r.prototype.indexes.default={name:"UNIVERSAL",selector:function(){return!0},element:function(){return[!0]}},c="function"==typeof window.Map?window.Map:function(){function e(){this.map={}}return e.prototype.get=function(e){return this.map[e+" "]},e.prototype.set=function(e,t){this.map[e+" "]=t},e}();var l=/((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^\[\]]*\]|['"][^'"]*['"]|[^\[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g;function d(e,t){var n,r,o,i,s,a,c=(e=e.slice(0).concat(e.default)).length,u=t,d=[];do{if(l.exec(""),(o=l.exec(u))&&(u=o[3],o[2]||!u))for(n=0;n<c;n++)if(s=(a=e[n]).selector(o[1])){for(r=d.length,i=!1;r--;)if(d[r].index===a&&d[r].key===s){i=!0;break}i||d.push({index:a,key:s});break}}while(o);return d}function f(e,t){var n,r,o;for(n=0,r=e.length;n<r;n++)if(o=e[n],t.isPrototypeOf(o))return o}function h(e,t){return e.id-t.id}r.prototype.logDefaultIndexUsed=function(){},r.prototype.add=function(e,t){var n,r,o,i,s,a,u,l,h=this.activeIndexes,p=this.selectors,v=this.selectorObjects;if("string"==typeof e){for(v[(n={id:this.uid++,selector:e,data:t}).id]=n,u=d(this.indexes,e),r=0;r<u.length;r++)i=(l=u[r]).key,(s=f(h,o=l.index))||((s=Object.create(o)).map=new c,h.push(s)),o===this.indexes.default&&this.logDefaultIndexUsed(n),(a=s.map.get(i))||(a=[],s.map.set(i,a)),a.push(n);this.size++,p.push(e)}},r.prototype.remove=function(e,t){if("string"==typeof e){var n,r,o,i,s,a,c,u,l=this.activeIndexes,f=this.selectors=[],h=this.selectorObjects,p={},v=1===arguments.length;for(n=d(this.indexes,e),o=0;o<n.length;o++)for(r=n[o],i=l.length;i--;)if(a=l[i],r.index.isPrototypeOf(a)){if(c=a.map.get(r.key))for(s=c.length;s--;)(u=c[s]).selector!==e||!v&&u.data!==t||(c.splice(s,1),p[u.id]=!0);break}for(o in p)delete h[o],this.size--;for(o in h)f.push(h[o].selector)}},r.prototype.queryAll=function(e){if(!this.selectors.length)return[];var t,n,r,o,i,s,a,c,u={},l=[],d=this.querySelectorAll(this.selectors.join(", "),e);for(t=0,r=d.length;t<r;t++)for(i=d[t],n=0,o=(s=this.matches(i)).length;n<o;n++)u[(c=s[n]).id]?a=u[c.id]:(a={id:c.id,selector:c.selector,data:c.data,elements:[]},u[c.id]=a,l.push(a)),a.elements.push(i);return l.sort(h)},r.prototype.matches=function(e){if(!e)return[];var t,n,r,o,i,s,a,c,u,l,d,f=this.activeIndexes,p={},v=[];for(t=0,o=f.length;t<o;t++)if(c=(a=f[t]).element(e))for(n=0,i=c.length;n<i;n++)if(u=a.map.get(c[n]))for(r=0,s=u.length;r<s;r++)!p[d=(l=u[r]).id]&&this.matchesSelector(e,l.selector)&&(p[d]=!0,v.push(l));return v.sort(h)};var p={},v={},g=new WeakMap,y=new WeakMap,m=new WeakMap,b=Object.getOwnPropertyDescriptor(Event.prototype,"currentTarget");function w(e,t,n){var r=e[t];return e[t]=function(){return n.apply(e,arguments),r.apply(e,arguments)},e}function x(){g.set(this,!0)}function O(){g.set(this,!0),y.set(this,!0)}function S(){return m.get(this)||null}function j(e,t){b&&Object.defineProperty(e,"currentTarget",{configurable:!0,enumerable:!0,get:t||b.get})}function k(e){if(function(e){try{return e.eventPhase,!0}catch(e){return!1}}(e)){var t=(1===e.eventPhase?v:p)[e.type];if(t){var n=function(e,t,n){var r=[],o=t;do{if(1!==o.nodeType)break;var i=e.matches(o);if(i.length){var s={node:o,observers:i};n?r.unshift(s):r.push(s)}}while(o=o.parentElement);return r}(t,e.target,1===e.eventPhase);if(n.length){w(e,"stopPropagation",x),w(e,"stopImmediatePropagation",O),j(e,S);for(var r=0,o=n.length;r<o&&!g.get(e);r++){var i=n[r];m.set(e,i.node);for(var s=0,a=i.observers.length;s<a&&!y.get(e);s++)i.observers[s].data.call(i.node,e)}m.delete(e),j(e)}}}}function C(e,t,n){var o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{},i=!!o.capture,s=i?v:p,a=s[e];a||(a=new r,s[e]=a,document.addEventListener(e,k,i)),a.add(t,n)}function F(e,t,n){return e.dispatchEvent(new CustomEvent(t,{bubbles:!0,cancelable:!0,detail:n}))}},612:function(e,t,n){"use strict";n.d(t,"b",(function(){return r})),n.d(t,"a",(function(){return o}));const r="accordionContainer:opened",o="accordionContainer:closed"},677:function(e,t,n){},747:function(e,t,n){"use strict";n.r(t);var r=n(597),o=n.n(r),i=(n(677),n(610)),s=n(612);class a{constructor(){this.containerSelector=".redux-group-tab .travelpayouts-accordion",this.bindEvents=()=>{const{headerSelector:e,onToggleHeader:t,onOpen:n}=this;Object(i.b)("click",e,t),Object(i.b)(s.b,"body",n)},this.onOpen=e=>{const t="travelpayouts-accordion__content--init",{detail:{contentContainer:n}}=e;if(!n.hasClass(t)){const e=o.a.redux;e&&(e.initFields(),n.addClass(t))}},this.onToggleHeader=e=>{const{currentTarget:t}=e;if(t){const e=".travelpayouts-accordion__content",n="travelpayouts-accordion__header--visible",r=o()(t),a=r.hasClass(n),c=r.next(e),u={contentContainer:c};a?(r.removeClass(n),c.slideUp(100,(()=>Object(i.a)(document.body,s.a,u)))):(r.addClass(n),c.slideDown(100,(()=>Object(i.a)(document.body,s.b,u))))}},this.headerSelector=`${this.containerSelector} .travelpayouts-accordion__header`}init(){this.bindEvents()}}o()((()=>{(new a).init()}))}}]);