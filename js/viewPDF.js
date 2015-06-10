
function viewPDF(filename){	console.log(filename);
    Registry['fullscreen-container'] = document.getElementById('fullscreen-container');
    Registry['nav-back'] = document.getElementById('nav-back');

    var back = Registry['nav-back'];
    back.style.display="none";

    var cnt = Registry['fullscreen-container'];
    cnt.style.display="block";
    cnt.innerHTML = '<a class="pdf-close" onclick="closeFSC()">Закрыть</a><iframe id="pdf-iframe" src="'+filename+'" style="width:100%; height:100%;" frameborder="1"></iframe>';
}

function closeFSC(){
    var cnt = Registry['fullscreen-container'];
    cnt.style.display="none";

    var back = Registry['nav-back'];
    back.style.display="block";
}
