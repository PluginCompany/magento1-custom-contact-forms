//formstone core
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):e(jQuery)}(function(e){"use strict";function t(e,t,n,s){var i,r={raw:{}};s=s||{};for(i in s)s.hasOwnProperty(i)&&("classes"===e?(r.raw[s[i]]=t+"-"+s[i],r[s[i]]="."+t+"-"+s[i]):(r.raw[i]=s[i],r[i]=s[i]+"."+t));for(i in n)n.hasOwnProperty(i)&&("classes"===e?(r.raw[i]=n[i].replace(/{ns}/g,t),r[i]=n[i].replace(/{ns}/g,"."+t)):(r.raw[i]=n[i].replace(/.{ns}/g,""),r[i]=n[i].replace(/{ns}/g,t)));return r}function n(){p.windowWidth=p.$window.width(),p.windowHeight=p.$window.height(),g=f.startTimer(g,y,s)}function s(){for(var e in p.ResizeHandlers)p.ResizeHandlers.hasOwnProperty(e)&&p.ResizeHandlers[e].callback.call(window,p.windowWidth,p.windowHeight)}function i(){if(p.support.raf){p.window.requestAnimationFrame(i);for(var e in p.RAFHandlers)p.RAFHandlers.hasOwnProperty(e)&&p.RAFHandlers[e].callback.call(window)}}function r(e,t){return parseInt(e.priority)-parseInt(t.priority)}var o,a,c,l="undefined"!=typeof window?window:this,u=l.document,d=function(){this.Version="@version",this.Plugins={},this.DontConflict=!1,this.Conflicts={fn:{}},this.ResizeHandlers=[],this.RAFHandlers=[],this.window=l,this.$window=e(l),this.document=u,this.$document=e(u),this.$body=null,this.windowWidth=0,this.windowHeight=0,this.fallbackWidth=1024,this.fallbackHeight=768,this.userAgent=window.navigator.userAgent||window.navigator.vendor||window.opera,this.isFirefox=/Firefox/i.test(this.userAgent),this.isChrome=/Chrome/i.test(this.userAgent),this.isSafari=/Safari/i.test(this.userAgent)&&!this.isChrome,this.isMobile=/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(this.userAgent),this.isIEMobile=/IEMobile/i.test(this.userAgent),this.isFirefoxMobile=this.isFirefox&&this.isMobile,this.transform=null,this.transition=null,this.support={file:!!(window.File&&window.FileList&&window.FileReader),history:!!(window.history&&window.history.pushState&&window.history.replaceState),matchMedia:!(!window.matchMedia&&!window.msMatchMedia),pointer:!!window.PointerEvent,raf:!(!window.requestAnimationFrame||!window.cancelAnimationFrame),touch:!!("ontouchstart"in window||window.DocumentTouch&&document instanceof window.DocumentTouch),transition:!1,transform:!1}},f={killEvent:function(e,t){try{e.preventDefault(),e.stopPropagation(),t&&e.stopImmediatePropagation()}catch(e){}},killGesture:function(e){try{e.preventDefault()}catch(e){}},lockViewport:function(t){v[t]=!0,e.isEmptyObject(v)||b||(o.length?o.attr("content",c):o=e("head").append('<meta name="viewport" content="'+c+'">'),p.$body.on(m.gestureChange,f.killGesture).on(m.gestureStart,f.killGesture).on(m.gestureEnd,f.killGesture),b=!0)},unlockViewport:function(t){"undefined"!==e.type(v[t])&&delete v[t],e.isEmptyObject(v)&&b&&(o.length&&(a?o.attr("content",a):o.remove()),p.$body.off(m.gestureChange).off(m.gestureStart).off(m.gestureEnd),b=!1)},startTimer:function(e,t,n,s){return f.clearTimer(e),s?setInterval(n,t):setTimeout(n,t)},clearTimer:function(e,t){e&&(t?clearInterval(e):clearTimeout(e),e=null)},sortAsc:function(e,t){return parseInt(e,10)-parseInt(t,10)},sortDesc:function(e,t){return parseInt(t,10)-parseInt(e,10)},decodeEntities:function(e){var t=p.document.createElement("textarea");return t.innerHTML=e,t.value},parseQueryString:function(e){for(var t={},n=e.slice(e.indexOf("?")+1).split("&"),s=0;s<n.length;s++){var i=n[s].split("=");t[i[0]]=i[1]}return t}},p=new d,h=e.Deferred(),w={base:"{ns}",element:"{ns}-element"},m={namespace:".{ns}",beforeUnload:"beforeunload.{ns}",blur:"blur.{ns}",change:"change.{ns}",click:"click.{ns}",dblClick:"dblclick.{ns}",drag:"drag.{ns}",dragEnd:"dragend.{ns}",dragEnter:"dragenter.{ns}",dragLeave:"dragleave.{ns}",dragOver:"dragover.{ns}",dragStart:"dragstart.{ns}",drop:"drop.{ns}",error:"error.{ns}",focus:"focus.{ns}",focusIn:"focusin.{ns}",focusOut:"focusout.{ns}",gestureChange:"gesturechange.{ns}",gestureStart:"gesturestart.{ns}",gestureEnd:"gestureend.{ns}",input:"input.{ns}",keyDown:"keydown.{ns}",keyPress:"keypress.{ns}",keyUp:"keyup.{ns}",load:"load.{ns}",mouseDown:"mousedown.{ns}",mouseEnter:"mouseenter.{ns}",mouseLeave:"mouseleave.{ns}",mouseMove:"mousemove.{ns}",mouseOut:"mouseout.{ns}",mouseOver:"mouseover.{ns}",mouseUp:"mouseup.{ns}",panStart:"panstart.{ns}",pan:"pan.{ns}",panEnd:"panend.{ns}",resize:"resize.{ns}",scaleStart:"scalestart.{ns}",scaleEnd:"scaleend.{ns}",scale:"scale.{ns}",scroll:"scroll.{ns}",select:"select.{ns}",swipe:"swipe.{ns}",touchCancel:"touchcancel.{ns}",touchEnd:"touchend.{ns}",touchLeave:"touchleave.{ns}",touchMove:"touchmove.{ns}",touchStart:"touchstart.{ns}"},g=null,y=20,v=[],b=!1;return d.prototype.NoConflict=function(){p.DontConflict=!0;for(var t in p.Plugins)p.Plugins.hasOwnProperty(t)&&(e[t]=p.Conflicts[t],e.fn[t]=p.Conflicts.fn[t])},d.prototype.Ready=function(e){"complete"===p.document.readyState||"loading"!==p.document.readyState&&!p.document.documentElement.doScroll?e():p.document.addEventListener("DOMContentLoaded",e)},d.prototype.Plugin=function(n,s){return p.Plugins[n]=function(n,s){function i(t){var i,r,a,l="object"===e.type(t),u=Array.prototype.slice.call(arguments,l?1:0),d=this,f=e();for(t=e.extend(!0,{},s.defaults||{},l?t:{}),r=0,a=d.length;r<a;r++)if(i=d.eq(r),!o(i)){s.guid++;var p="__"+s.guid,h=s.classes.raw.base+p,w=i.data(n+"-options"),m=e.extend(!0,{$el:i,guid:p,numGuid:s.guid,rawGuid:h,dotGuid:"."+h},t,"object"===e.type(w)?w:{});i.addClass(s.classes.raw.element).data(c,m),s.methods._construct.apply(i,[m].concat(u)),f=f.add(i)}for(r=0,a=f.length;r<a;r++)i=f.eq(r),s.methods._postConstruct.apply(i,[o(i)]);return d}function o(e){return e.data(c)}var a="fs-"+n,c="fs"+n.replace(/(^|\s)([a-z])/g,function(e,t,n){return t+n.toUpperCase()});return s.initialized=!1,s.priority=s.priority||10,s.classes=t("classes",a,w,s.classes),s.events=t("events",n,m,s.events),s.functions=e.extend({getData:o,iterate:function(t){for(var n=this,s=Array.prototype.slice.call(arguments,1),i=0,r=n.length;i<r;i++){var a=n.eq(i),c=o(a)||{};"undefined"!==e.type(c.$el)&&t.apply(a,[c].concat(s))}return n}},f,s.functions),s.methods=e.extend(!0,{_construct:e.noop,_postConstruct:e.noop,_destruct:e.noop,_resize:!1,destroy:function(e){s.functions.iterate.apply(this,[s.methods._destruct].concat(Array.prototype.slice.call(arguments,1))),this.removeClass(s.classes.raw.element).removeData(c)}},s.methods),s.utilities=e.extend(!0,{_initialize:!1,_delegate:!1,defaults:function(t){s.defaults=e.extend(!0,s.defaults,t||{})}},s.utilities),s.widget&&(p.Conflicts.fn[n]=e.fn[n],e.fn[c]=function(t){if(this instanceof e){var n=s.methods[t];if("object"===e.type(t)||!t)return i.apply(this,arguments);if(n&&0!==t.indexOf("_")){var r=[n].concat(Array.prototype.slice.call(arguments,1));return s.functions.iterate.apply(this,r)}return this}},p.DontConflict||(e.fn[n]=e.fn[c])),p.Conflicts[n]=e[n],e[c]=s.utilities._delegate||function(t){var n=s.utilities[t]||s.utilities._initialize||!1;if(n){var i=Array.prototype.slice.call(arguments,"object"===e.type(t)?0:1);return n.apply(window,i)}},p.DontConflict||(e[n]=e[c]),s.namespace=n,s.namespaceClean=c,s.guid=0,s.methods._resize&&(p.ResizeHandlers.push({namespace:n,priority:s.priority,callback:s.methods._resize}),p.ResizeHandlers.sort(r)),s.methods._raf&&(p.RAFHandlers.push({namespace:n,priority:s.priority,callback:s.methods._raf}),p.RAFHandlers.sort(r)),s}(n,s),p.Plugins[n]},p.$window.on("resize.fs",n),n(),i(),p.Ready(function(){p.$body=e("body"),e("html").addClass(p.support.touch?"touchevents":"no-touchevents"),o=e('meta[name="viewport"]'),a=!!o.length&&o.attr("content"),c="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0",h.resolve()}),m.clickTouchStart=m.click+" "+m.touchStart,function(){var e,t={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"otransitionend",transition:"transitionend"},n=["transition","-webkit-transition"],s={transform:"transform",MozTransform:"-moz-transform",OTransform:"-o-transform",msTransform:"-ms-transform",webkitTransform:"-webkit-transform"},i="transitionend",r="",o="",a=document.createElement("div");for(e in t)if(t.hasOwnProperty(e)&&e in a.style){i=t[e],p.support.transition=!0;break}m.transitionEnd=i+".{ns}";for(e in n)if(n.hasOwnProperty(e)&&n[e]in a.style){r=n[e];break}p.transition=r;for(e in s)if(s.hasOwnProperty(e)&&s[e]in a.style){p.support.transform=!0,o=s[e];break}p.transform=o}(),window.Formstone=p,p});

!function(e){"function"==typeof define&&define.amd?define(["jquery","./core"],e):e(jQuery,Formstone)}(function(e,t){"use strict";function a(e,t,a){t.error=!0,e.$el.trigger(y.fileError,[t,a]),e.aborting||h(e)}function r(e,t,r){e.$el.trigger(y.chunkError,[t,r]),a(e,t,r)}function n(e){e.disabled&&(this.removeClass($.disabled),e.$input.prop("disabled",!1),e.disabled=!1)}function i(e){S.killEvent(e);var t=e.data;t.disabled||t.$input.trigger(y.click)}function l(e){e.data.$el.addClass($.focus)}function o(e){e.data.$el.removeClass($.focus)}function u(e){S.killEvent(e);var t=e.data,a=t.$input[0].files;!t.disabled&&a.length&&p(t,a)}function s(e){S.killEvent(e),e.data.$el.addClass($.dropping).trigger(y.fileDragEnter)}function c(e){S.killEvent(e),e.data.$el.addClass($.dropping).trigger(y.fileDragOver)}function d(e){S.killEvent(e),e.data.$el.removeClass($.dropping).trigger(y.fileDragLeave)}function f(e){S.killEvent(e);var t=e.data,a=e.originalEvent.dataTransfer.files;t.$el.removeClass($.dropping),t.disabled||p(t,a)}function p(e,t){var a=[],r=t.length;if(e.maxFiles){var n=e.maxFiles-e.uploaded;n>=0&&t.length>n&&(r=n)}if(r>0){for(var i=0;i<r;i++){var l={index:e.total++,file:t[i],name:t[i].name,size:t[i].size,started:!1,complete:!1,error:!1,transfer:null};a.push(l),e.queue.push(l)}e.$el.trigger(y.queued,[a]),e.autoUpload&&g(e)}e.$input.val("")}function g(e){e.uploading||(q.on(y.beforeUnload,function(){return e.leave}),e.uploading=!0,e.$el.trigger(y.start,[e.queue])),h(e)}function h(e){var t=0,a=[];for(var r in e.queue)!e.queue.hasOwnProperty(r)||e.queue[r].complete||e.queue[r].error||a.push(e.queue[r]);e.queue=a;for(var n in e.queue)if(e.queue.hasOwnProperty(n)){if(e.queue[n].started||v(e,e.queue[n]),++t>=e.maxConcurrent)return;r++}0===t&&(q.off(y.beforeUnload),e.uploading=!1,e.$el.trigger(y.complete))}function v(t,r){if(r.size>=t.maxSize||!0===r.error)a(t,r,"size");else if(t.chunked)r.started=!0,r.chunkSize=1024*t.chunkSize,r.totalChunks=Math.ceil(r.size/r.chunkSize),r.currentChunk=0,t.$el.trigger(y.fileStart,[r]),m(t,r);else{var n=new FormData;n.append(t.postKey,r.file),!1===(n=k(t,n,r))?a(t,r,"abort"):(r.started=!0,r.transfer=e.ajax({url:t.action,data:n,dataType:t.dataType,type:"POST",contentType:!1,processData:!1,cache:!1,xhr:function(){var a=e.ajaxSettings.xhr();return a.upload&&a.upload.addEventListener("progress",function(e){var a=0,n=e.loaded||e.position,i=e.total;e.lengthComputable&&(a=Math.ceil(n/i*100)),t.$el.trigger(y.fileProgress,[r,a])},!1),a},beforeSend:function(e,a){t.$el.trigger(y.fileStart,[r,a,e])},success:function(e,a,n){r.complete=!0,t.uploaded++,t.$el.trigger(y.fileComplete,[r,e,a,n]),h(t)},error:function(e,n,i){a(t,r,i,e)}}))}}function m(t,n){var i=n.chunkSize*n.currentChunk,l=i+n.chunkSize;l>n.size&&(l=n.size);var o=n.file[w](i,l),u=new FormData;u.append(t.postKey,o,n.file.name),u.append("chunks",n.totalChunks),u.append("chunk",n.currentChunk),!1===(u=k(t,u,n))?a(t,n,"abort"):n.chunkTransfer=e.ajax({url:t.action,data:u,dataType:t.dataType,type:"POST",contentType:!1,processData:!1,cache:!1,beforeSend:function(e,a){t.$el.trigger(y.chunkStart,[n,a,e])},success:function(e,a,r){n.currentChunk++,t.$el.trigger(y.chunkComplete,[n]);var i=Math.ceil(n.currentChunk/n.totalChunks*100);t.$el.trigger(y.fileProgress,[n,i,a,r]),n.currentChunk<n.totalChunks?m(t,n):(n.complete=!0,t.$el.trigger(y.fileComplete,[n,e,a,r]),h(t))},error:function(e,a,i){r(t,n,i,e)}})}function k(e,t,a){for(var r in e.postData)e.postData.hasOwnProperty(r)&&t.append(r,e.postData[r]);return t=e.beforeSend.call(e.$el,t,a)}var b=t.Plugin("upload",{widget:!0,defaults:{accept:!1,action:"",autoUpload:!0,beforeSend:function(e){return e},chunked:!1,chunkSize:100,customClass:"",dataType:"html",label:"Drag and drop files or click to select",leave:"You have uploads pending, are you sure you want to leave this page?",maxConcurrent:2,maxFiles:!1,maxSize:5242880,multiple:!0,postData:{},postKey:"file",theme:"fs-light"},classes:["input","target","multiple","dropping","disabled","focus"],methods:{_construct:function(e){if(t.support.file){var a="";w||(e.chunked=!1),e.maxQueue&&(e.maxConcurrent=e.maxQueue),!1!==e.label&&(a+='<div class="'+$.target+'">',a+=e.label,a+="</div>"),a+='<input class="'+$.input+'" type="file"',e.multiple&&(a+=" multiple"),e.accept&&(a+=' accept="'+e.accept+'"'),a+=">",e.baseClasses=[$.base,e.theme,e.customClass].join(" "),this.addClass(e.baseClasses).append(a),e.$input=this.find(C.input),e.queue=[],e.total=0,e.uploaded=0,e.uploading=!1,e.disabled=!0,e.aborting=!1,this.on(y.click,C.target,e,i).on(y.dragEnter,e,s).on(y.dragOver,e,c).on(y.dragLeave,e,d).on(y.drop,e,f),e.$input.on(y.focus,e,l).on(y.blur,e,o).on(y.change,e,u),n.call(this,e)}},_destruct:function(e){t.support.file&&(e.$input.off(y.namespace),this.off(y.namespace).removeClass(e.baseClasses).html(""))},disable:function(e){e.disabled||(this.addClass($.disabled),e.$input.prop("disabled",!0),e.disabled=!0)},enable:n,abort:function(t,r){var n;t.aborting=!0;for(var i in t.queue)t.queue.hasOwnProperty(i)&&(n=t.queue[i],("undefined"===e.type(r)||r>=0&&n.index===r)&&(n.started&&!n.complete?t.chunked?n.chunkTransfer.abort():n.transfer.abort():a(t,n,"abort")));t.aborting=!1,h(t)},start:g}}),C=b.classes,$=C.raw,y=b.events,S=b.functions,q=(t.window,t.$window),w=!1;t.Ready(function(){var e=["mozSlice","webkitSlice","slice"];if(t.support.file){var a=!1;try{a=new File([""],"f")}catch(e){}if(!a)try{a=new Blob([""],{})}catch(e){}if(a)for(var r in e)if(e.hasOwnProperty(r)&&e[r]in a){w=e[r];break}}}),y.chunkComplete="chunkcomplete",y.chunkError="chunkerror",y.chunkStart="chunkstart",y.complete="complete",y.fileComplete="filecomplete",y.fileDragEnter="filedragenter",y.fileDragLeave="filedragleave",y.fileDragOver="filedragover",y.fileError="fileerror",y.fileProgress="fileprogress",y.fileStart="filestart",y.start="start",y.queued="queued"});

//custom
function PCCFUploadOnStart(e, files) {
    //console.log("Start");
    var upload = jQuery(e.currentTarget).parents('.pcfileupload');
    var fileQueue = upload.find('.queue');
    var fileList = upload.find('.complete');
    var html = '';
    for (var i = 0; i < files.length; i++) {
        html += '<li data-index="' + files[i].index + '"><span class="file">' + files[i].name + '</span><span class="progress">' + files[i].name + '</span></li>';
    }
    fileQueue.append(html);
    var prnts = upload.parents('.pcform_bottom_left,.pcform_bottom_right');
    if(prnts.length){
        slideOutResize(prnts);
    }
    if(typeof jQuery.colorbox != 'undefined'){
        jQuery.colorbox.resize();
    }
}

function PCCFUploadOnComplete(e) {
    //console.log("Complete");
    // All done!

}

function PCCFUploadOnFileStart(e, file) {
    //console.log("File Start");
    var upload = jQuery(e.target).parents('.pcfileupload');
    var fileQueue = upload.find('.queue');
    fileQueue.find("li[data-index=" + file.index + "]")
        .find(".progress").css('width','2%');
}

function PCCFUploadOnFileProgress(e, file, percent) {
    //console.log("File Progress");
    var upload = jQuery(e.target).parents('.pcfileupload');
    var fileQueue = upload.find('.queue');
    fileQueue.find("li[data-index=" + file.index + "]")
        .find(".progress").css('width', percent + "%");
}

function PCCFUploadOnFileComplete(e, file, response) {
    //console.log(e);
    //console.log(file);
    //console.log(response);
    //console.log("File Complete");
    var upload = jQuery(e.target).parents('.pcfileupload');
    var fileQueue = upload.find('.queue');
    var fileList = upload.find('.complete');
    if (response.trim() === "" || response.toLowerCase().indexOf("error") > -1) {
        console.log('error');
        fileQueue.find("li[data-index=" + file.index + "]")
            .find('.progress').text(response)
            .css('width','100%')
            .css('background-color','#F59595');

        if(fileList.find('li').length == 0){
            //no successful uploads
            var fem = jQuery(e.target).find("input[type='file']");
            if(fem.hasClass('is-required')){
                fem.addClass('required-entry');
            }
            fem.prop('value',"");
        }

    } else {
        var target = fileQueue.find("li[data-index=" + file.index + "]");
        target.find(".file").text(file.name);
        target.find(".progress").css('width','100%').append('<img src="' + PCCBaseJSURL + 'contactforms/img/x.png" onclick="PCCFRemoveFile(\'' + file.name + '\',this)" />');
        target.appendTo(fileList);
        target.find(".progress").css('background-color','rgb(85, 213, 100)');

        //This is for making files selected on drag&drop.
        //Because Formstone doesn't make it selected on drag& drop.
        var fem = jQuery(e.target).find("input[type='file']");
        if(fem.hasClass('required-entry')){
            fem.addClass('is-required');
        }
        fem.removeClass("required-entry");
    }
    var prnts = upload.parents('.pcform_bottom_left,.pcform_bottom_right');
    if(prnts.length){
        slideOutResize(prnts);
    }
    if(typeof jQuery.colorbox != 'undefined'){
        jQuery.colorbox.resize();
    }
}

function PCCFUploadOnFileError(e, file, error) {
    //console.log("File Error");
    var upload = jQuery(e.target).parents('.pcfileupload');
    var fileQueue = upload.find('.queue');
    if(error == 'size'){
        error = 'File exeeds max allowed file size'
    }
    fileQueue.find("li[data-index=" + file.index + "]")
        .find('.progress').text(error)
        .css('width','100%')
        .css('background-color','#F59595');
}

function PCCFRemoveFile(fileName,em){
    //get parent en ids en shit
    var parentId = jQuery(em).closest('.pccf').attr('formid');
    var uniqId = jQuery(em).closest('.pccf').find('.pcc_uid').val();
    var index = $PC(em).parents('.pccf').find('.filelists').index($PC(em).closest('.filelists'));
    var url = PCCFileUploadUrl.slice(0,-7) + 'deleteupload/' + 'form_id/' + parentId + '/uid/' + uniqId + '/index/' + index + '/filename/' + fileName;
    $PC.get(url,function(data){
    	if(jQuery(em).closest('ul.filelist.complete').find("li").length==1){
            var fem = jQuery(em).closest(".pcfileupload").find("input[type='file']");
            if(fem.hasClass('is-required')){
                fem.addClass('required-entry');
                fem.prop('value',"");
            }
        }
        jQuery(em).closest('li').remove();
    });
}