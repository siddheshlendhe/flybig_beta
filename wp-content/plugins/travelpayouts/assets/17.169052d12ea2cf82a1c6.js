(window.travelpayoutsWpPlugin=window.travelpayoutsWpPlugin||[]).push([[17],{136:function(e,t,a){e.exports={stylesModalBody:"styles-modal-body__2VTly",stylesModalFooter:"styles-modal-footer__1gEzi"}},19:function(e,t,a){"use strict";a.d(t,"a",(function(){return i})),a.d(t,"b",(function(){return n})),a.d(t,"e",(function(){return c})),a.d(t,"d",(function(){return o})),a.d(t,"c",(function(){return l})),a.d(t,"h",(function(){return u})),a.d(t,"f",(function(){return m})),a.d(t,"g",(function(){return g}));var s=a(4);const n=e=>Object(s.c)((({dialogProps:t,dialogConfig:a},{dispatch:s})=>{s(r({dialogName:e,dialogProps:t,dialogConfig:a}))})),c=e=>[Object(s.c)((({dialogProps:t,dialogConfig:a},{dispatch:s})=>{s(r({dialogName:e,dialogProps:t,dialogConfig:a}))})),Object(s.c)(((t,{dispatch:a})=>{a(o(e))})),e],r=Object(s.c)("openDialog"),o=Object(s.c)("closeDialog"),l=Object(s.c)("closeAllDialogs"),i=Object(s.d)("dialog",{},(e=>[e(r,((e,{dialogName:t,dialogProps:a={},dialogConfig:s={}})=>e[t]&&e[t].visible?e:Object.assign(Object.assign({},e),{[t]:{visible:!0,dialogConfig:s,dialogProps:a}}))),e(o,((e,t)=>e[t]?Object.assign(Object.assign({},e),{[t]:Object.assign(Object.assign({},e[t]),{visible:!1})}):e)),e(l,(()=>({})))])),d=Object(s.f)(Object(s.a)([i]),(([e])=>t=>e[t])),u=Object(s.f)(Object(s.a)([d]),(([e])=>t=>{const a=e(t);return a&&a.visible})),m=Object(s.f)(Object(s.a)([d]),(([e])=>t=>{const a=e(t);return a&&a.dialogConfig})),g=Object(s.f)(Object(s.a)([d]),(([e])=>t=>{const a=e(t);return a&&a.dialogProps}))},264:function(e,t,a){"use strict";a.d(t,"a",(function(){return l}));var s=a(3),n=a.n(s),c=a(0),r=a.n(c),o=a(136);const l=e=>{const{children:t,className:a,style:s}=e;return r.a.createElement("div",{style:s,className:n()(o.stylesModalFooter,a)},t)}},265:function(e,t,a){"use strict";a.d(t,"a",(function(){return r}));var s=a(85),n=a(17),c=a(266);const r=s.v.create({className:c.stylesContainer,position:n.a.TOP})},266:function(e,t,a){e.exports={stylesContainer:"styles-container__2mR2z"}},267:function(e,t,a){e.exports={stylesTagWrapper:"styles-tag-wrapper__39qpG"}},49:function(e,t,a){"use strict";a.d(t,"a",(function(){return u}));var s=a(3),n=a.n(s),c=a(0),r=a.n(c),o=a(85),l=a(5),i=a(19),d=a(136);const u=e=>{const{name:t,width:a,className:s,destroyOnClose:c=!0,bodyComponent:u,canEscapeKeyClose:m=!0,canOutsideClickClose:g=!0,wrapBody:f=!0}=e,p=Object(l.c)(i.h)(t),h=Object(l.c)(i.f)(t),b=Object(l.c)(i.g)(t),y=Object(l.b)(i.d),v=h&&h.title;if(!p&&c)return null;const _=()=>y(t);return r.a.createElement(o.f,{title:v,className:n()(s),style:{width:a},isOpen:p,onClose:_,canEscapeKeyClose:m,canOutsideClickClose:g,enforceFocus:!1},f?r.a.createElement("div",{className:n()(d.stylesModalBody)},r.a.createElement(u,Object.assign({closeDialog:_},b))):r.a.createElement(u,Object.assign({closeDialog:_},b)))}},57:function(e,t,a){"use strict";a.d(t,"a",(function(){return s})),a.d(t,"b",(function(){return i})),a.d(t,"c",(function(){return d}));const s=e=>({disabled:!e.length,minimal:!0,fill:!0});var n=a(0),c=a.n(n),r=a(252),o=a.n(r),l=a(85);const i=e=>(t,a)=>{const{modifiers:{active:s,disabled:n,matchesPredicate:r},handleClick:o,index:i}=a,d=e(t,a);return d&&r?c.a.createElement(l.m,{key:i,active:s,disabled:n,onClick:n?void 0:o,text:d}):null},d=({items:e,itemsParentRef:t,query:a,renderItem:s})=>{const n=e.map(s).filter((e=>null!=e));return c.a.createElement(l.l,{ulRef:t,style:{overflow:"inherit"}},c.a.createElement(o.a,{autoHeightMax:300,autoHeight:!0},n))}},620:function(e,t,a){"use strict";var s=a(654);a.o(s,"deleteManyItems")&&a.d(t,"deleteManyItems",(function(){return s.deleteManyItems})),a.o(s,"fetchRawData")&&a.d(t,"fetchRawData",(function(){return s.fetchRawData})),a.o(s,"searchFormCreate")&&a.d(t,"searchFormCreate",(function(){return s.searchFormCreate})),a.o(s,"searchFormUpdate")&&a.d(t,"searchFormUpdate",(function(){return s.searchFormUpdate})),a.o(s,"searchFormsFetch")&&a.d(t,"searchFormsFetch",(function(){return s.searchFormsFetch})),a.o(s,"translationsFetcher")&&a.d(t,"translationsFetcher",(function(){return s.translationsFetcher})),a.o(s,"wpAdminAjax")&&a.d(t,"wpAdminAjax",(function(){return s.wpAdminAjax}));var n=a(655);a.d(t,"deleteManyItems",(function(){return n.a})),a.d(t,"fetchRawData",(function(){return n.b})),a.d(t,"searchFormCreate",(function(){return n.c})),a.d(t,"searchFormUpdate",(function(){return n.d})),a.d(t,"searchFormsFetch",(function(){return n.e})),a.d(t,"translationsFetcher",(function(){return n.f})),a.d(t,"wpAdminAjax",(function(){return n.g}))},623:function(e,t,a){e.exports={stylesTableFill:"styles-table--fill__MMGPZ",stylesTableIsLoading:"styles-table-is-loading__28iWU",stylesPagination:"styles-pagination__16nuI",stylesPaginationTotalPages:"styles-pagination-totalPages__2CcZi",stylesPaginationTotalPagesPageNumber:"styles-pagination-totalPages-page-number__3Gtfm",stylesPaginationTotalPagesDelimiter:"styles-pagination-totalPages-delimiter__2vdhv",stylesCheckbox:"styles-checkbox__2Lsjp",stylesCheckboxCell:"styles-checkbox-cell__37GJx"}},654:function(e,t){},655:function(e,t,a){"use strict";a.d(t,"g",(function(){return c})),a.d(t,"e",(function(){return r})),a.d(t,"d",(function(){return o})),a.d(t,"c",(function(){return l})),a.d(t,"f",(function(){return i})),a.d(t,"b",(function(){return d})),a.d(t,"a",(function(){return u}));var s=a(81),n=function(e,t,a,s){return new(a||(a=Promise))((function(n,c){function r(e){try{l(s.next(e))}catch(e){c(e)}}function o(e){try{l(s.throw(e))}catch(e){c(e)}}function l(e){var t;e.done?n(e.value):(t=e.value,t instanceof a?t:new a((function(e){e(t)}))).then(r,o)}l((s=s.apply(e,t||[])).next())}))};const c=a.n(s).a.create({baseURL:"/wp-admin/admin-ajax.php",params:{action:"travelpayouts_routes"}}),r=()=>n(void 0,void 0,void 0,(function*(){try{const e=yield c.get("",{params:{page:"searchForms"}}),{data:t,success:a}=e.data;return a?t:null}catch(e){return console.warn({e:e}),null}})),o=(e,t)=>n(void 0,void 0,void 0,(function*(){try{const a=yield c.put("",{query:t},{params:{page:`searchForms/update/${e}`}}),{data:s,success:n,meta:r}=a.data;return n?{data:s,meta:r}:null}catch(e){return console.warn({e:e}),null}})),l=e=>n(void 0,void 0,void 0,(function*(){try{const t=yield c.post("",{query:e},{params:{page:"searchForms/create"}}),{data:a,success:s,meta:n}=t.data;return s?{data:a,meta:n}:null}catch(e){return console.warn({e:e}),null}})),i=()=>n(void 0,void 0,void 0,(function*(){try{const e=yield c.get("",{params:{page:"searchForms/translations"}}),{data:t,meta:a,success:s}=e.data;return s&&t?{data:t,meta:a}:null}catch(e){return console.warn({e:e}),null}})),d=()=>n(void 0,void 0,void 0,(function*(){try{const e=yield c.get("",{params:{page:"searchForms/raw-data"}}),{data:t,success:a}=e.data;return a&&t?t:null}catch(e){return console.warn({e:e}),null}})),u=e=>n(void 0,void 0,void 0,(function*(){try{const t=yield c.put("",{query:e},{params:{page:"searchForms/delete"}}),{data:a,success:s}=t.data;return s&&a?a:null}catch(e){return console.warn({e:e}),null}}))},661:function(e,t,a){e.exports={stylesDescription:"styles-description__1wPir",stylesActionBar:"styles-action-bar__2AY_I",stylesActionBarButton:"styles-action-bar-button__3MoP_",stylesHelpLink:"styles-help-link__37fqN"}},726:function(e,t,a){e.exports={stylesFooter:"styles-footer__3MYx4",stylesFooterSmall:"styles-footer--small__1Cc6C",stylesWrapper:"styles-wrapper__31tTN"}},727:function(e,t,a){e.exports={stylesWrapper:"styles-wrapper__1JjOa",stylesIcon:"styles-icon__2hlBN",stylesId:"styles-id__3F7hz",stylesText:"styles-text__3Hs__"}},728:function(e,t,a){e.exports={stylesDescription:"styles-description__170SJ",stylesDescriptionContent:"styles-description-content__EhDeB",stylesDescriptionIcon:"styles-description-icon__1CkwA"}},735:function(e,t,a){e.exports={stylesCalloutWrapper:"styles-callout-wrapper__3m8Kh",stylesTextarea:"styles-textarea__1LEAU",stylesFooterActions:"styles-footer-actions__12hZq"}},738:function(e,t,a){e.exports={stylesActionBar:"styles-action-bar__3JwH3",stylesActionBarButton:"styles-action-bar-button__2I13r",stylesGridPagination:"styles-grid-pagination__14n5_",stylesGridCellDate:"styles-grid-cell-date__3c7Y7",stylesGridCellActions:"styles-grid-cell-actions__sU0yW"}},742:function(e,t,a){"use strict";a.r(t),a.d(t,"SearchForms",(function(){return at}));a(361),a(362),a(363);var s=a(0),n=a.n(s),c=a(656),r=(a(364),a(5)),o=a(620),l=a(4),i=a(3),d=a.n(i),u=a(252),m=a.n(u),g=a(750),f=a(85),p=a(19),h=a(49),b=a(1),y=a(264),v=a(726);const _=e=>n.a.createElement(y.a,{className:d()(v.stylesWrapper)},n.a.createElement("div",{className:d()(b.a.DIALOG_FOOTER,v.stylesFooter,{[v.stylesFooterSmall]:"small"===e.type})},n.a.createElement("div",{className:d()(b.a.DIALOG_FOOTER_ACTIONS,e.className)},e.children)));var O=a(727);const j=e=>{const{item:t}=e;return n.a.createElement("div",{className:d()(O.stylesWrapper)},n.a.createElement("div",{className:d()(O.stylesIcon)},n.a.createElement(f.j,{icon:"trash"})),n.a.createElement("div",{className:d()(O.stylesText)},t.title))};var E=a(728);const w=e=>{const{items:t,onConfirm:a,closeDialog:s}=e,{formatMessage:c}=Object(g.a)();return n.a.createElement("div",null,n.a.createElement("div",{className:d()(E.stylesDescription)},n.a.createElement("div",{className:d()(E.stylesDescriptionIcon)},n.a.createElement(f.j,{icon:"warning-sign",iconSize:20})),n.a.createElement("div",{className:d()(E.stylesDescriptionContent)},c({id:"grid_button_remove_items_description",defaultMessage:"{num, plural, one {# item} other {# items}} will be removed. This operation cannot be undone."},{num:t.length}))),n.a.createElement(m.a,{autoHeightMax:300,autoHeight:!0},n.a.createElement("div",null,t.map(((e,t)=>n.a.createElement(j,{key:t,item:e}))))),n.a.createElement(_,{type:"small"},n.a.createElement(f.b,{onClick:()=>s()},c({id:"button_cancel",defaultMessage:"Cancel"})),n.a.createElement(f.b,{intent:"danger",onClick:()=>a()},c({id:"button_delete",defaultMessage:"Delete"}))))},[C,P,S]=Object(p.e)("search-forms-delete"),M=()=>n.a.createElement(h.a,{name:S,bodyComponent:w,width:350,canEscapeKeyClose:!0,canOutsideClickClose:!0});var x=a(741),F=a(752),N=a(603),I=function(e,t,a,s){return new(a||(a=Promise))((function(n,c){function r(e){try{l(s.next(e))}catch(e){c(e)}}function o(e){try{l(s.throw(e))}catch(e){c(e)}}function l(e){var t;e.done?n(e.value):(t=e.value,t instanceof a?t:new a((function(e){e(t)}))).then(r,o)}l((s=s.apply(e,t||[])).next())}))};const k={request:Object(l.c)("translations/request",((e,{dispatch:t})=>I(void 0,void 0,void 0,(function*(){const e=yield Object(o.translationsFetcher)();if(e){const{data:a,meta:s}=e,{locale:n}=s,c=Object(F.a)({locale:n,messages:a},Object(N.d)());t(k.success({currentLocale:n,intl:c}))}})))),success:Object(l.c)("translations/success"),failure:Object(l.c)("translations/failure")},D={intlShape:Object(F.a)({locale:"en",messages:{},defaultLocale:"en"},Object(N.d)()),currentLocale:"en"},T=Object(l.d)("translations",D,(e=>[e(k.success,((e,t)=>Object.assign(Object.assign({},e),{intlShape:t.intl,currentLocale:t.currentLocale})))])),A=Object(l.f)(T,(e=>e.intlShape)),R=Object(l.f)(T,(e=>e.currentLocale)),q=Object(l.f)(R,(e=>"ru"===e?"ru":"en"));var B=a(81),G=a.n(B),H=a(196),L=a.n(H),W=a(599),z=a(57),U=a(267),V=function(e,t,a,s){return new(a||(a=Promise))((function(n,c){function r(e){try{l(s.next(e))}catch(e){c(e)}}function o(e){try{l(s.throw(e))}catch(e){c(e)}}function l(e){var t;e.done?n(e.value):(t=e.value,t instanceof a?t:new a((function(e){e(t)}))).then(r,o)}l((s=s.apply(e,t||[])).next())}))};const $=e=>{const{value:t,allowClear:a,debounce:c=300,onChange:r,fetchOptions:o,itemsEqual:l,inputValueRenderer:i,itemRenderer:u,inputProps:m,disabled:g}=e,[p,h]=Object(s.useState)([]),b=e=>{r&&r(e)},y=L()((e=>V(void 0,void 0,void 0,(function*(){var t;if(e.length){const a=null!==(t=yield o(e))&&void 0!==t?t:[];h(a)}}))),c);return n.a.createElement(W.a,{onQueryChange:y,selectedItem:t,items:p,inputValueRenderer:i,noResults:n.a.createElement(n.a.Fragment,null),fill:!0,popoverProps:Object(z.a)(p),itemsEqual:l,itemRenderer:u,onItemSelect:b,resetOnSelect:!0,disabled:g,inputProps:Object.assign(Object.assign({},m),{rightElement:a&&!g&&t?n.a.createElement(f.s,{className:d()(U.stylesTagWrapper),minimal:!0,round:!0,interactive:!0,icon:"small-cross",onClick:()=>b(null)}):void 0}),itemListRenderer:z.c})};var J=function(e,t,a,s){return new(a||(a=Promise))((function(n,c){function r(e){try{l(s.next(e))}catch(e){c(e)}}function o(e){try{l(s.throw(e))}catch(e){c(e)}}function l(e){var t;e.done?n(e.value):(t=e.value,t instanceof a?t:new a((function(e){e(t)}))).then(r,o)}l((s=s.apply(e,t||[])).next())}))},K=function(e,t){var a={};for(var s in e)Object.prototype.hasOwnProperty.call(e,s)&&t.indexOf(s)<0&&(a[s]=e[s]);if(null!=e&&"function"==typeof Object.getOwnPropertySymbols){var n=0;for(s=Object.getOwnPropertySymbols(e);n<s.length;n++)t.indexOf(s[n])<0&&Object.prototype.propertyIsEnumerable.call(e,s[n])&&(a[s[n]]=e[s[n]])}return a};const Y=e=>{const{value:t,allowClear:a,debounce:s=300,onChange:c,inputProps:r,locale:o="en",disabled:l}=e;return n.a.createElement($,{value:t,fetchOptions:e=>J(void 0,void 0,void 0,(function*(){try{const{data:t}=yield G.a.get("https://autocomplete.travelpayouts.com/places2",{params:{term:e,locale:o,types:["city"]}});return t.map((e=>{var{cases:t,index_strings:a,country_cases:s}=e;return K(e,["cases","index_strings","country_cases"])}))}catch(e){return console.warn({e:e}),[]}})),inputValueRenderer:e=>e?`${e.name}, ${e.country_name}`:"",itemRenderer:Object(z.b)((e=>`${e.name}, ${e.country_name}`)),itemsEqual:"code",onChange:c,allowClear:a,debounce:s,inputProps:r,disabled:l})};var Z=function(e,t,a,s){return new(a||(a=Promise))((function(n,c){function r(e){try{l(s.next(e))}catch(e){c(e)}}function o(e){try{l(s.throw(e))}catch(e){c(e)}}function l(e){var t;e.done?n(e.value):(t=e.value,t instanceof a?t:new a((function(e){e(t)}))).then(r,o)}l((s=s.apply(e,t||[])).next())}))};const Q=e=>{const{value:t,allowClear:a,debounce:s=300,onChange:c,inputProps:r,locale:o="en",disabled:l}=e;return n.a.createElement($,{value:t,fetchOptions:e=>Z(void 0,void 0,void 0,(function*(){try{const{data:t}=yield G.a.get("https://yasen.hotellook.com/autocomplete",{params:{term:e,lang:o}}),{cities:a,hotels:s}=t,n=s.map((e=>({name:e.name,location:e.locationFullName,hotels_count:"",search_id:e.id,search_type:"hotel",country_name:e.country}))),c=a.map((e=>({name:e.city,location:e.fullname,hotels_count:"",search_id:e.id,search_type:"city",country_name:e.country})));return[...n,...c]}catch(e){return[]}})),inputValueRenderer:e=>e?`${e.name}, ${e.location}`:"",itemRenderer:Object(z.b)((e=>`${e.name}, ${e.location}`)),itemsEqual:"search_id",onChange:c,allowClear:a,debounce:s,inputProps:r,disabled:l})};var X=a(735);const ee=e=>{if(!e)return!1;const t=![e.match(/window\.TP_FORM_SETTINGS = window\.TP_FORM_SETTINGS \|\|\s{};/),e.match(/window\.TP_FORM_SETTINGS\["([^"]*)"]/),e.match(/src="\/\/www\.travelpayouts\.com\/widgets/)].includes(null);if(t){const t=e.match(/window\.TP_FORM_SETTINGS\["(?<widgetId>[\w]+)"](\s?=\s?)(?<widgetParams>[^;]+)/);if(t){const{groups:{widgetParams:e}}=t;try{return JSON.parse(e),!0}catch(e){return!1}}return!1}return t},te=e=>{const{item:t,closeDialog:a,onSubmit:s}=e,{formatMessage:c}=Object(g.a)(),o=Object(r.c)(q),l=Object(r.b)(Pe),i=null!=t?t:{code_form:"",title:"",from_city:null,to_city:null,hotel_city:null,applyParams:!1},u=Object(x.a)({initialValues:i,onSubmit:s,validate:e=>{const{title:t,code_form:a}=e,s={title:t.length<3?c({id:"validation_string_length_short",defaultMessage:"{attribute} should contain at least {min} characters."},{attribute:c({id:"item_title",defaultMessage:"Title"}),min:"3"}):void 0,code_form:ee(a)?void 0:c({id:"validation_invalid_value",defaultMessage:"{attribute} has invalid value"},{attribute:c({id:"item_widget_code",defaultMessage:"Generated widget code"})})};if(Object.values(s).filter((e=>!!e)).length)return s}});return n.a.createElement("form",{onSubmit:u.handleSubmit},n.a.createElement(f.h,{label:c({id:"item_title",defaultMessage:"Title"}),labelFor:"title",labelInfo:"*"},n.a.createElement(f.k,{id:"title",name:"title",onChange:u.handleChange,value:u.values.title,intent:u.errors.title&&u.touched.title?"danger":void 0,autoFocus:!0}),u.errors.title&&u.touched.title&&n.a.createElement(f.d,{className:d()(X.stylesCalloutWrapper),intent:"danger",icon:null},u.errors.title)),n.a.createElement(f.h,{label:c({id:"item_widget_code",defaultMessage:"Generated widget code"}),labelFor:"code_form",labelInfo:"*"},n.a.createElement(f.u,{className:d()(X.stylesTextarea),id:"code_form",name:"code_form",growVertically:!1,fill:!0,onChange:u.handleChange,value:u.values.code_form,intent:u.errors.code_form&&u.touched.code_form?"danger":void 0}),u.errors.code_form&&u.touched.code_form&&n.a.createElement(f.d,{className:d()(X.stylesCalloutWrapper),intent:"danger",icon:null},u.errors.code_form)),n.a.createElement(f.h,{labelFor:"applyParams"},n.a.createElement(f.e,{id:"applyParams",name:"applyParams",checked:u.values.applyParams,onChange:({target:e})=>{u.setFieldValue("applyParams",e.checked,!1)},label:c({id:"item_apply_params",defaultMessage:"Apply parameters (origin, destination, etc.) from generated widget code"})})),n.a.createElement(f.h,{label:c({id:"item_from_city",defaultMessage:"Default departure city"}),labelFor:"from_city"},n.a.createElement(Y,{value:u.values.from_city,allowClear:!0,onChange:e=>u.setFieldValue("from_city",e),inputProps:{id:"from_city",name:"from_city",placeholder:""},locale:o,disabled:u.values.applyParams})),n.a.createElement(f.h,{label:c({id:"item_to_city",defaultMessage:"Default arrival city"}),labelFor:"to_city"},n.a.createElement(Y,{value:u.values.to_city,allowClear:!0,onChange:e=>u.setFieldValue("to_city",e),inputProps:{id:"to_city",name:"to_city",placeholder:""},locale:o,disabled:u.values.applyParams})),n.a.createElement(f.h,{label:c({id:"item_city_hotel",defaultMessage:"Default city or hotel"}),labelFor:"hotel_city"},n.a.createElement(Q,{value:u.values.hotel_city,allowClear:!0,onChange:e=>u.setFieldValue("hotel_city",e),inputProps:{id:"hotel_city",name:"hotel_city",placeholder:""},locale:o,disabled:u.values.applyParams})),n.a.createElement(_,{type:"small"},n.a.createElement(f.b,{type:"button",onClick:()=>l(),icon:"help",minimal:!0}),n.a.createElement(f.b,{onClick:()=>a(),tabIndex:1},c({id:"button_cancel",defaultMessage:"Cancel"})),n.a.createElement(f.b,{onClick:()=>u.submitForm(),intent:"primary",tabIndex:0},c(t?{id:"button_save",defaultMessage:"Save"}:{id:"button_add",defaultMessage:"Add"}))))},[ae,se,ne]=Object(p.e)("create-update-search-form"),ce=()=>n.a.createElement(h.a,{name:ne,bodyComponent:te,width:520,canEscapeKeyClose:!0,canOutsideClickClose:!1});var re=function(e,t,a,s){return new(a||(a=Promise))((function(n,c){function r(e){try{l(s.next(e))}catch(e){c(e)}}function o(e){try{l(s.throw(e))}catch(e){c(e)}}function l(e){var t;e.done?n(e.value):(t=e.value,t instanceof a?t:new a((function(e){e(t)}))).then(r,o)}l((s=s.apply(e,t||[])).next())}))};const oe={request:Object(l.c)("search-forms/fetch/request",((e,{dispatch:t})=>re(void 0,void 0,void 0,(function*(){const e=yield Object(o.searchFormsFetch)();t(e?oe.success({data:e}):oe.failure())})))),success:Object(l.c)("search-forms/fetch/success"),failure:Object(l.c)("search-forms/fetch/failure")},le={set:Object(l.c)("search-forms/id/set"),clear:Object(l.c)("search-forms/id/clear"),setMany:Object(l.c)("search-forms/check")},ie={run:Object(l.c)("search-forms/create/run",((e,{dispatch:t})=>re(void 0,void 0,void 0,(function*(){t(Ce())})))),showDialog:Object(l.c)("search-forms/create/showDialog",((e,{dispatch:t,getState:a})=>re(void 0,void 0,void 0,(function*(){const{formatMessage:e}=a(A);t(ae({dialogProps:{onSubmit:e=>{t(ie.request({value:e}))}},dialogConfig:{title:e({id:"item_add_title",defaultMessage:"Add a new search form"})}}))})))),request:Object(l.c)("search-forms/create/request",(({value:e},{dispatch:t,getState:a})=>re(void 0,void 0,void 0,(function*(){const{formatMessage:s}=a(A);t(xe.hide("search-forms/create")),t(xe.show({message:s({id:"request_processing",defaultMessage:"Sending data. Please wait"}),intent:"primary",icon:"more",id:"search-forms/create"}));const n=yield Object(o.searchFormCreate)(e);if(n){const{data:e}=n;t(oe.success({data:[...a(Te),e]})),t(ie.success())}else t(de.failure())})))),success:Object(l.c)("search-forms/update/success",((e,{getState:t,dispatch:a})=>{const{formatMessage:s}=t(A);a(xe.hide("search-forms/create")),a(xe.show({message:s({id:"item_create_success",defaultMessage:"Search form has been created"}),intent:"success",icon:"saved",id:"search-forms/create"})),a(ge.update({})),a(se())})),failure:Object(l.c)("search-forms/update/failure")},de={showDialog:Object(l.c)("search-forms/update/showDialog",(({id:e},{dispatch:t,getState:a})=>re(void 0,void 0,void 0,(function*(){t(le.set(e));const{formatMessage:s}=a(A),n=a(ze);n&&t(ae({dialogProps:{item:n,onSubmit:a=>re(void 0,void 0,void 0,(function*(){t(de.request({id:e,value:a}))}))},dialogConfig:{title:s({id:"item_edit_title",defaultMessage:'Edit the search form "{searchForm_name}"'},{searchForm_name:n.title})}}))})))),request:Object(l.c)("search-forms/update/request",(({id:e,value:t},{dispatch:a,getState:s})=>re(void 0,void 0,void 0,(function*(){const{formatMessage:n}=s(A);a(xe.hide("search-forms/update")),a(xe.show({message:n({id:"request_processing",defaultMessage:"Sending data. Please wait"}),intent:"primary",icon:"more",id:"search-forms/update"}));const c=yield Object(o.searchFormUpdate)(e,t);if(c){a(xe.hide("search-forms/update"));const{data:e,meta:t}=c,n=s(Te).filter((({id:e})=>e!==t.id));a(oe.success({data:[...n,e]})),a(de.success())}else a(de.failure())})))),success:Object(l.c)("search-forms/update/success",((e,{getState:t,dispatch:a})=>{const{formatMessage:s}=t(A);a(xe.hide("search-forms/update")),a(xe.show({message:s({id:"item_update_success",defaultMessage:"Search form has been updated"}),intent:"success",icon:"saved",id:"search-forms/update"})),a(ge.update({})),a(se())})),failure:Object(l.c)("search-forms/update/failure",((e,{dispatch:t})=>{t(ge.update({}))}))},ue={deleteSelectedItems:Object(l.c)("search-forms/delete-many/request",((e,{dispatch:t,getState:a})=>re(void 0,void 0,void 0,(function*(){const e=a(Le);e.length&&t(ue.showDialog({data:e}))})))),deleteOneItem:Object(l.c)("search-forms/delete/request",(({id:e},{dispatch:t,getState:a})=>re(void 0,void 0,void 0,(function*(){t(le.set(e));const s=a(ze);s&&t(ue.showDialog({data:[s]}))})))),showDialog:Object(l.c)("search-forms/delete-many/show-dialog",(({data:e},{dispatch:t})=>re(void 0,void 0,void 0,(function*(){const a=e.map((e=>e.id));t(xe.hide("search-forms/delete-many")),t(C({dialogProps:{items:e,onConfirm:()=>t(ue.success({idList:a}))}}))})))),success:Object(l.c)("search-forms/delete-many/success",(({idList:e},{dispatch:t,getState:a})=>re(void 0,void 0,void 0,(function*(){const{formatMessage:s}=a(A);t(xe.show({message:s({id:"request_processing",defaultMessage:"Sending data. Please wait"}),intent:"primary",icon:"more",id:"search-forms/delete-many"}));const n=yield Object(o.deleteManyItems)(e);if(n){const e=a(Te).filter((({id:e})=>-1===n.indexOf(e)));t(oe.success({data:e})),t(xe.hide("search-forms/delete-many")),t(xe.show({message:s({id:"request_delete_success",defaultMessage:"{num, plural, one {# search form} other {# search forms}} was successfully removed."},{num:n.length}),intent:"success",icon:"saved",id:"search-forms/delete-many"})),t(P()),t(me([]))}t(ge.update({}))})))),failure:Object(l.c)("search-forms/delete-many/failure",((e,{dispatch:t})=>{t(ge.update({})),t(me([]))}))},me=Object(l.c)("search-forms/check"),ge={set:Object(l.c)("search-forms/output-selector/set"),update:Object(l.c)("search-forms/output-selector/update",(({fireEvent:e=!0},{getState:t})=>re(void 0,void 0,void 0,(function*(){const a=t(Ae);if(a){const t=yield Object(o.fetchRawData)();if(t){const s=new Event("change",{bubbles:!0});e&&(a.value=t,a.dispatchEvent(s))}}}))))};var fe=a(661);const pe=e=>{const{closeDialog:t}=e,{formatMessage:a}=Object(g.a)(),s=Object(r.b)(ie.showDialog),c=Object(r.b)(Pe);return n.a.createElement("div",{className:d()(fe.stylesActionBar)},n.a.createElement("div",{className:d()(fe.stylesActionBarButton)},n.a.createElement(f.b,{fill:!0,large:!0,autoFocus:!0,onClick:()=>{s(),t()},intent:"primary"},a({id:"introduce_form_code_exists",defaultMessage:"I have a generated widget code"}))),n.a.createElement("div",{className:d()(fe.stylesActionBarButton)},n.a.createElement(f.b,{fill:!0,large:!0,onClick:()=>{c(),t()}},a({id:"introduce_form_code_not_exists",defaultMessage:"I don't have a code"}))))},[he,be,ye]=Object(p.e)("introduce-dialog"),ve=()=>n.a.createElement(n.a.Fragment,null,n.a.createElement(h.a,{name:ye,bodyComponent:pe,width:400})),_e=e=>{const{formatMessage:t}=Object(g.a)();return n.a.createElement("div",null,n.a.createElement("div",{className:d()("bp3-ui-text bp3-running-text bp3-text-large",fe.stylesDescription)},t({id:"introduce_description",defaultMessage:"You need to create a new search form at Travelpayouts.com and get the widget code to add the form to the plugin"})),n.a.createElement("div",{className:d()(fe.stylesActionBar)},n.a.createElement("div",{className:d()(fe.stylesActionBarButton)},n.a.createElement(f.a,{fill:!0,large:!0,href:"https://app.travelpayouts.com/programs/100/tools/search_forms",target:"_blank",text:t({id:"introduce_form_create_button",defaultMessage:"Create an {source} form"},{source:"Aviasales/Jetradar"})})),n.a.createElement("div",{className:d()(fe.stylesActionBarButton)},n.a.createElement(f.a,{fill:!0,large:!0,href:"https://app.travelpayouts.com/programs/101/tools/search_forms",target:"_blank",text:t({id:"introduce_form_create_button",defaultMessage:"Create an {source} form"},{source:"Hotellook"})}))),n.a.createElement("div",{className:d()(fe.stylesHelpLink)},t({id:"introduce_form_tutorial_link",defaultMessage:"Here is a {tutorial_link} in help"},{tutorial_link:n.a.createElement("a",{target:"_blank",href:"https://support.travelpayouts.com/hc/en-us/articles/115000456691-Adding-Search-Forms-with-plugin"},t({id:"introduce_form_tutorial_link_title",defaultMessage:"tutorial"}))})),n.a.createElement(_,{type:"small"},n.a.createElement(f.b,{intent:"primary",onClick:()=>e.onConfirm()},t({id:"introduce_form_ok",defaultMessage:"Ok, got it"}))))},[Oe,je,Ee]=Object(p.e)("help-dialog"),we=()=>n.a.createElement(h.a,{name:Ee,bodyComponent:_e,width:500}),Ce=Object(l.c)("search-forms/introduce/step-one",((e,{dispatch:t,getState:a})=>{const{formatMessage:s}=a(A);t(he({dialogConfig:{title:s({id:"item_add_title",defaultMessage:"Add a new search form"})}}))})),Pe=Object(l.c)("search-forms/introduce/step-two",((e,{dispatch:t})=>{t(Oe({dialogProps:{onConfirm:()=>{t(je()),t(ie.showDialog())}}}))}));var Se=a(265),Me=function(e,t){var a={};for(var s in e)Object.prototype.hasOwnProperty.call(e,s)&&t.indexOf(s)<0&&(a[s]=e[s]);if(null!=e&&"function"==typeof Object.getOwnPropertySymbols){var n=0;for(s=Object.getOwnPropertySymbols(e);n<s.length;n++)t.indexOf(s[n])<0&&Object.prototype.propertyIsEnumerable.call(e,s[n])&&(a[s[n]]=e[s[n]])}return a};const xe={show:Object(l.c)("toast/show",(e=>{const{id:t}=e,a=Me(e,["id"]);Se.a.show(a,t)})),hide:Object(l.c)("toast/hide",(e=>{Se.a.dismiss(e)}))},Fe=Object(l.d)("searchForms",{isPending:!1,isSuccess:!1,data:[],currentSearchFormId:null,selectedSearchFormIds:[],outputSelector:null},(e=>[e(oe.success,((e,{data:t})=>Object.assign(Object.assign({},e),{isPending:!1,isSuccess:!0,data:t}))),e(oe.request,(e=>Object.assign(Object.assign({},e),{isPending:!0,isSuccess:!1}))),e(oe.failure,(e=>Object.assign(Object.assign({},e),{isPending:!1,isSuccess:!1}))),e(le.set,((e,t)=>Object.assign(Object.assign({},e),{currentSearchFormId:t}))),e(le.clear,(e=>Object.assign(Object.assign({},e),{currentSearchFormId:null}))),e(le.setMany,((e,t)=>Object.assign(Object.assign({},e),{selectedSearchFormIds:t}))),e(ge.set,((e,t)=>Object.assign(Object.assign({},e),{outputSelector:t})))]));var Ne=a(197),Ie=a.n(Ne),ke=a(268),De=a.n(ke);const Te=Object(l.f)(Fe,(e=>e.data)),Ae=Object(l.f)(Fe,(e=>e.outputSelector)),Re=Object(l.f)(Object(l.a)([Te,A]),(([e,t])=>{const{formatDate:a}=t;return e.map((e=>{const t=De()(e.date_add,"yyyy-MM-dd",new Date);return Object.assign(Object.assign({},e),{date_add:Ie()(t)?a(t):e.date_add})}))})),qe=Object(l.f)(Re,(e=>e.sort(((e,t)=>e.id<t.id?1:-1)))),Be=Object(l.f)(Fe,(e=>e.isPending)),Ge=Object(l.f)(Fe,(e=>e.currentSearchFormId)),He=Object(l.f)(Fe,(e=>e.selectedSearchFormIds)),Le=Object(l.f)(Object(l.a)([Te,He]),(([e,t])=>e.filter((({id:e})=>-1!==t.indexOf(e.toString()))))),We=Object(l.f)(Le,(e=>e.length)),ze=Object(l.f)(Object(l.a)([Te,Ge]),(([e,t])=>{const a=e.find((e=>e.id===t));return null!=a?a:null})),Ue=()=>n.a.createElement(n.a.Fragment,null,n.a.createElement(ce,null),n.a.createElement(M,null),n.a.createElement(ve,null),n.a.createElement(we,null));var Ve=a(736),$e=a(623);const Je=e=>n.a.createElement(f.e,Object.assign({className:$e.stylesCheckbox},e));var Ke=e=>{const{canPreviousPage:t,canNextPage:a,pageOptions:s,pageCount:c,gotoPage:r,nextPage:o,previousPage:l,pageIndex:i}=e;return n.a.createElement("div",{className:d()("pagination",$e.stylesPagination)},n.a.createElement(f.c,null,n.a.createElement(f.b,{onClick:()=>r(0),disabled:!t},n.a.createElement(f.j,{icon:"double-chevron-left"})),n.a.createElement(f.b,{onClick:()=>l(),disabled:!t},n.a.createElement(f.j,{icon:"chevron-left"}))),n.a.createElement("div",{className:d()($e.stylesPaginationTotalPages)},n.a.createElement("div",{className:d()($e.stylesPaginationTotalPagesPageNumber)},i+1),n.a.createElement("div",{className:d()($e.stylesPaginationTotalPagesDelimiter)},"/"),n.a.createElement("div",{className:d()($e.stylesPaginationTotalPagesPageNumber)},s.length)),n.a.createElement(f.c,null,n.a.createElement(f.b,{onClick:()=>o(),disabled:!a},n.a.createElement(f.j,{icon:"chevron-right"})),n.a.createElement(f.b,{onClick:()=>r(c-1),disabled:!a},n.a.createElement(f.j,{icon:"double-chevron-right"}))))};const Ye=e=>{const{data:t,columns:a,onSelect:c,showHeaderSelection:r,getRowId:o,pageSize:l,currentPage:i=0,onChangePage:u,fill:m,bordered:g,condensed:p,interactive:h,striped:b,paginationContainerClassName:y,tableContainerClassName:v,isLoading:_,noDataPlaceholder:O}=e,j=n.a.useMemo((()=>a),[a]),E=n.a.useMemo((()=>t),[t]),{getTableProps:w,getTableBodyProps:C,headerGroups:P,flatHeaders:S,prepareRow:M,page:x,canPreviousPage:F,canNextPage:N,pageOptions:I,pageCount:k,gotoPage:D,nextPage:T,previousPage:A,setPageSize:R,state:{pageIndex:q,pageSize:B,selectedRowIds:G}}=Object(Ve.useTable)({columns:j,data:E,initialState:{pageIndex:i,pageSize:l},getRowId:o},Ve.usePagination,Ve.useRowSelect,(e=>{c&&e.visibleColumns.push((e=>[{id:"selection",headerClassName:$e.stylesCheckboxCell,Header:({getToggleAllRowsSelectedProps:e})=>r&&n.a.createElement(Je,Object.assign({},e())),Cell:({row:e})=>n.a.createElement(Je,Object.assign({},e.getToggleRowSelectedProps()))},...e]))})),H={page:x,canPreviousPage:F,canNextPage:N,pageOptions:I,pageCount:k,gotoPage:D,nextPage:T,previousPage:A,setPageSize:R,pageIndex:q,pageSize:B};return Object(s.useEffect)((()=>{q!==i&&D(i)}),[i]),Object(s.useEffect)((()=>{u&&q!==i&&u(q)}),[q]),Object(s.useEffect)((()=>{c&&c(Object.keys(G))}),[G]),n.a.createElement(n.a.Fragment,null,n.a.createElement("div",{className:v},n.a.createElement("table",Object.assign({className:d()("bp3-html-table",{"bp3-html-table-bordered":g,"bp3-html-table-condensed":p,"bp3-interactive":h,"bp3-html-table-striped":b,[$e.stylesTableFill]:m})},w()),n.a.createElement("thead",null,P.map((e=>n.a.createElement("tr",Object.assign({},e.getHeaderGroupProps()),e.headers.map((e=>n.a.createElement("th",Object.assign({},e.getHeaderProps({className:e.headerClassName})),e.render("Header")))))))),n.a.createElement("tbody",Object.assign({},C()),x.map((e=>(M(e),n.a.createElement("tr",Object.assign({},e.getRowProps()),e.cells.map((e=>n.a.createElement("td",Object.assign({},e.getCellProps({className:e.column.cellClassName})),e.render("Cell")))))))),_&&n.a.createElement("tr",{role:"row"},n.a.createElement("td",{role:"cell",colSpan:S.length},n.a.createElement(f.r,{size:32,className:$e.stylesTableIsLoading}))),!_&&!!O&&0===E.length&&n.a.createElement("tr",{role:"row"},n.a.createElement("td",{role:"cell",colSpan:S.length},O))))),E.length>B?n.a.createElement("div",{className:y},n.a.createElement(Ke,Object.assign({},H))):null)};var Ze=a(738);const Qe=()=>{const e=Object(r.b)(oe.request),t=Object(r.c)(qe),a=Object(r.c)(Be),c=Object(r.b)(de.showDialog),o=Object(r.b)(ie.run),l=Object(r.b)(ue.deleteOneItem),i=Object(r.b)(le.setMany),u=Object(r.b)(ue.deleteSelectedItems),m=Object(r.c)(We),[p,h]=Object(s.useState)(0),{formatMessage:b}=Object(g.a)();return Object(s.useEffect)((()=>{e()}),[]),n.a.createElement("div",null,n.a.createElement("div",{className:d()(Ze.stylesActionBar)},n.a.createElement(f.b,{className:d()(Ze.stylesActionBarButton),intent:"primary",onClick:()=>{h(0),o()}},b({id:"button_add_new_item",defaultMessage:"Add a new search form"})),m>0&&n.a.createElement(f.b,{className:d()(Ze.stylesActionBarButton),intent:"danger",icon:"trash",onClick:()=>u()},b({id:"grid_button_remove_items",defaultMessage:"Remove {num, plural, one {# item} other {# items}}"},{num:m}))),n.a.createElement(Ye,{paginationContainerClassName:Ze.stylesGridPagination,pageSize:10,data:t,onSelect:t.length?i:void 0,currentPage:p,onChangePage:h,columns:[{id:"title",accessor:"title",Header:b({id:"grid_column_title",defaultMessage:"Title"})},{id:"date",accessor:"date_add",Header:b({id:"grid_column_date",defaultMessage:"Date"}),headerClassName:Ze.stylesGridCellDate,cellClassName:Ze.stylesGridCellDate},{id:"shortcode",accessor:"id",Header:b({id:"grid_column_shortcode",defaultMessage:"Shortcode"}),Cell:({value:e})=>n.a.createElement(n.a.Fragment,null,'[tp_search_shortcodes id="',e,'"]')},{id:"actions",accessor:"id",Header:b({id:"grid_column_actions",defaultMessage:"Actions"}),headerClassName:Ze.stylesGridCellActions,cellClassName:Ze.stylesGridCellActions,Cell:e=>{const{value:t}=e;return n.a.createElement(f.c,null,n.a.createElement(f.b,{icon:"edit",intent:"primary",minimal:!0,onClick:()=>c({id:t})},b({id:"button_edit",defaultMessage:"Edit"})),n.a.createElement(f.b,{icon:"trash",intent:"danger",minimal:!0,onClick:()=>l({id:t})},b({id:"button_delete",defaultMessage:"Delete"})))}}],showHeaderSelection:t.length>0,getRowId:e=>e.id.toString(),bordered:!0,striped:!0,interactive:!0,fill:!0,isLoading:a,noDataPlaceholder:n.a.createElement("div",{style:{margin:"15px 0",textAlign:"center"}},n.a.createElement("div",{className:"bp3-ui-text bp3-text-large bp3-running-text bp3-text-muted bp3-text-disabled"},b({id:"grid_empty",defaultMessage:"You don't have any form added yet"})))}))},Xe=Object(l.a)([p.a,Fe,T]),et=Object(l.b)(Xe),tt=e=>{const{outputSelector:t,apiUrl:a}=e,l=Object(r.b)(k.request),i=Object(r.c)(A),d=Object(r.b)(ge.set),u=Object(r.b)(ge.update);return a&&(o.wpAdminAjax.defaults.baseURL=a),Object(s.useEffect)((()=>{if(l(),t){const e=document.querySelector(t);e&&(d(e),u({fireEvent:!1}))}}),[]),n.a.createElement(c.b,{value:i},n.a.createElement(Qe,null),n.a.createElement(Ue,null))},at=e=>(Object(s.useEffect)((()=>{0}),[]),n.a.createElement(r.a.Provider,{value:et},n.a.createElement(tt,Object.assign({},e))))}}]);