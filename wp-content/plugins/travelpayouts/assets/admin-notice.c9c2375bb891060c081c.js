(window.travelpayoutsWpPlugin=window.travelpayoutsWpPlugin||[]).push([[5],{498:function(t,e,n){n.e(29).then(n.t.bind(null,668,7));new class{constructor(){this.hideButtonEvents("travelpayouts-hide-temp"),this.settingsButtonEvents("travelpayouts-open-settings-tab")}hideButtonEvents(t){const e=document.getElementsByClassName(t);for(let t=0;t<e.length;t++){const n=e[t];n.addEventListener("click",(()=>this.hideTemp(n)))}}settingsButtonEvents(t){const e=document.getElementsByClassName(t);for(let t=0;t<e.length;t++){const n=e[t];n.addEventListener("click",(()=>this.setCurrentTab(n.getAttribute("data-tab"))))}}hideTemp(t){const e=t.getAttribute("data-name");document.cookie=`tp-notice-${e}=1; path=/`,this.hideNotice(t)}hideNotice(t){const e=t.closest(".travelpayouts-notice");e&&(e.style.display="none")}setCurrentTab(t){document.cookie="Redux_Travelpayouts_current_tab_travelpayouts_admin_settings="+t+"; path=/"}}}}]);