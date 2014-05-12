VI.addEvent("click","help",function(){
    var $infos = $(".a-help-info");
    var cName = this.className.split(" ");
    if(cName[1] === "open" ){
        cName = cName[0];
        this.innerHTML = "?";
        $infos.fadeOut();
    }else{
        cName = cName[0] + " open";
        this.innerHTML = "X";
        $infos.fadeIn();
    }
    this.className = cName;
});

VI.addEvent("click","close_help",function(){
    var btn = $('#help_btn')[0];
    btn.className = 'help';
    btn.innerHTML = "?";
    $(".a-help-info").fadeOut();
});
