
$(function(){
    $('.notification').click(function(){
        const idNotif = $(this).find('.idNotification').html();
        $.post("notifVue",{idNotif : idNotif});
        console.log('okkkkk');
        window.location.reload(true);
        $(this).removeClass("alert-primary");
        $(this).addClass("alert-primary");
    })
})

$(function(){
    $('.pagePlus').click(function(){
        $.post("pagePlus");
        window.location.reload(true);
    })
})

$(function(){
    $('.pageMoins').click(function(){
        $.post("pageMoins");
        window.location.reload(true);
    })
})

$(function(){
    $('.pageReset').click(function(){
        $.post("pageReset");
        window.location.reload(true);
    })
})
