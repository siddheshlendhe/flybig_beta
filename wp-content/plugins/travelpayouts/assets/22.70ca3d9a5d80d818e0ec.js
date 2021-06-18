/*! For license information please see 22.70ca3d9a5d80d818e0ec.js.LICENSE.txt */
(window.travelpayoutsWpPlugin=window.travelpayoutsWpPlugin||[]).push([[22],{3:function(e,t,n){!function(){"use strict";var t={}.hasOwnProperty;function n(){for(var e=[],r=0;r<arguments.length;r++){var s=arguments[r];if(s){var a=typeof s;if("string"===a||"number"===a)e.push(s);else if(Array.isArray(s)){if(s.length){var c=n.apply(null,s);c&&e.push(c)}}else if("object"===a)if(s.toString===Object.prototype.toString)for(var o in s)t.call(s,o)&&s[o]&&e.push(o);else e.push(s.toString())}}return e.join(" ")}e.exports?(n.default=n,e.exports=n):"function"==typeof define&&"object"==typeof define.amd&&define.amd?define("classnames",[],(function(){return n})):window.classNames=n}()},739:function(e,t,n){e.exports={stylesWrapper:"styles-wrapper__3INj0",stylesTitle:"styles-title__owQUi"}},740:function(e,t,n){e.exports={stylesWrapper:"styles-wrapper__1mMCu",stylesBody:"styles-body__1w9Pb",stylesHeader:"styles-header__305V_",stylesHeaderLink:"styles-header-link__32GgR"}},745:function(e,t,n){"use strict";n.r(t),n.d(t,"ZendeskFeed",(function(){return v}));var r=n(0),s=n.n(r),a=n(81),c=function(e,t,n,r){return new(n||(n=Promise))((function(s,a){function c(e){try{i(r.next(e))}catch(e){a(e)}}function o(e){try{i(r.throw(e))}catch(e){a(e)}}function i(e){var t;e.done?s(e.value):(t=e.value,t instanceof n?t:new n((function(e){e(t)}))).then(c,o)}i((r=r.apply(e,t||[])).next())}))};const o=n.n(a).a.create({baseURL:"https://travelpayouts.zendesk.com/api/v2/help_center"});var i=n(3),l=n.n(i),u=n(739);const y=e=>{const{article:t}=e,{title:n,html_url:r}=t;return s.a.createElement("div",{className:l()(u.stylesWrapper)},s.a.createElement("a",{className:l()(u.stylesTitle),href:r,target:"_blank"},n))};var d=n(740);const f=e=>{const{section:t}=e,{articles:n,name:r,html_url:a}=t;return s.a.createElement("div",{className:l()(d.stylesWrapper)},s.a.createElement("div",{className:l()(d.stylesHeader)},s.a.createElement("a",{className:l()(d.stylesHeaderLink),href:a,target:"_blank"},r)),s.a.createElement("div",{className:l()(d.stylesBody)},n.map(((e,t)=>s.a.createElement(y,{key:t,article:e})))))};var p=function(e,t,n,r){return new(n||(n=Promise))((function(s,a){function c(e){try{i(r.next(e))}catch(e){a(e)}}function o(e){try{i(r.throw(e))}catch(e){a(e)}}function i(e){var t;e.done?s(e.value):(t=e.value,t instanceof n?t:new n((function(e){e(t)}))).then(c,o)}i((r=r.apply(e,t||[])).next())}))};const v=e=>{const{lang:t}=e,n=(e=>({getArticlesByLabelName:t=>c(void 0,void 0,void 0,(function*(){const n="ru"===e?"ru":"en-us";try{const{data:e}=yield o.get(`/${n}/articles.json`,{params:{label_names:t}});if(e){const{articles:t}=e;return t}}catch(e){return console.warn({e:e}),[]}return[]})),getArticlesByCategoryId:t=>c(void 0,void 0,void 0,(function*(){const n="ru"===e?"ru":"en-us";try{const{data:e}=yield o.get(`/${n}/categories/${t}/articles`);if(e){const{articles:t}=e;return t}}catch(e){return console.warn({e:e}),[]}return[]})),getSectionsByCategoryId:t=>c(void 0,void 0,void 0,(function*(){const n="ru"===e?"ru":"en-us";try{const{data:e}=yield o.get(`/${n}/categories/${t}/sections`);if(e){const{sections:t}=e;return t}}catch(e){return console.warn({e:e}),[]}return[]}))}))(t),a=115000474547,[i,l]=Object(r.useState)([]),[u,y]=Object(r.useState)([]);Object(r.useEffect)((()=>{p(void 0,void 0,void 0,(function*(){const[e,t]=yield Promise.all([n.getSectionsByCategoryId(a),n.getArticlesByCategoryId(a)]);l(e),y(t)}))}),[]);const d=Object(r.useMemo)((()=>i.length&&u.length?i.map((e=>Object.assign(Object.assign({},e),{articles:u.filter((t=>t.section_id===e.id))}))):[]),[i,u]);return s.a.createElement("div",null,d.map(((e,t)=>s.a.createElement(f,{key:t,section:e}))))}}}]);