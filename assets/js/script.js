
/*----Apparition de la page de connexion----*/
$('.formConnexion').hide();
$(function(){
    $('.btnConnexion').click(function(){
        $('.titreAccueil').toggleClass('transitionY');
        $('.slogan').toggleClass('transitionY');
        $('.btnConnexion').toggleClass('transition-Y');
        $('.btnConnexion').hide();
        $('.formConnexion').fadeIn(1500);
        $('.formConnexion').addClass('transitionmin-Y');
    });
});
/*----Retour à l'accueil----*/
$(function(){
    $('.fas').click(function(){
        $('.formConnexion').hide();
        $('.btnConnexion').show();
        $('.btnConnexion').removeClass('transition-Y');
        $('.titreAccueil').removeClass('transitionY');
        $('.slogan').removeClass('transitionY');
        $('.titreAccueil').removeClass('transitionmin2-Y');
        $('.slogan').removeClass('transitionmin2-Y');
        $('.formConnexion').removeClass('transitionmin-Y');
    });
});
/*----Click sur le menu burger----*/
$(function(){
    $('.mobile').click(function(){
        $('.line1').toggleClass('mobileCrossP');
        $('.line2').toggleClass('mobileCrossM');
        $('.line3').toggleClass('d-none');
        $('.line1').toggleClass('marginT');
        $('.line2').toggleClass('marginO');
        $('.collapse').toggleClass('d-block')
    })
});
/*----Wishlist Add and Remove----*/
$(function(){
    $('.fa-heart').click(function(){
        $(this).toggleClass('far');
        $(this).toggleClass('fas');
        if($(this).hasClass("fas")){
            $titre = $(this).parent().find('.titre').html();
            $description = $(this).parent().find('.description').html();
            $entreprise = $(this).parent().find('.entreprise').html();
            $.post("Add",{titre : $titre,description : $description,entreprise : $entreprise});
        }else{
            $titre = $(this).parent().find('.titre').html();
            $description = $(this).parent().find('.description').html();
            $entreprise = $(this).parent().find('.entreprise').html();
            $.post("Remove",{titre : $titre,description : $description,entreprise : $entreprise});
        }
    })
})
/*----Affichage complet du stage----*/ 
$(function(){
    $('.stage').click(function(){
        const titre = $(this).find('.titre').html()
        const description = $(this).find('.description').html()
        const entreprise = $(this).find('.entreprise').html()
        const Competences = $(this).find('.idCompetence').html()
        $('.affichage').html("<h2>" + titre + "</h2><br><h4>Stage proposé par : "+ entreprise +"</h4><br><p>"+ description +"</p><p>Compétences requises:  "+ Competences +"</p><form method='post' enctype='multipart/form-data' action='Postulate'><h4>Merci d'ajouter ton CV et ta lettre de motivation ci-dessous :</h4><label>Mon CV :</label><input type='file' name='cv' required><label>Ma lettre de Motivation :</label><input type='file' name='motiv' required><input class='sub_postulate' name='sub_postulate' type=submit></form>")
        $.post("stagesession",{titre : titre,description : description,entreprise : entreprise});
    })
})
/*----Affichage complet du stage----*/ 
$(function(){
    $('.wishlist').click(function(){
        const titre = $(this).find('.titre').html()
        const description = $(this).find('.description').html()
        const entreprise = $(this).find('.entreprise').html()
        $('.affichage_wishlist').html("<h2>" + titre + "</h2><br><h4>Stage proposé par : "+ entreprise +"</h4><br><p>"+ description +"</p><form method='post' enctype='multipart/form-data' action='Postulate'><h4>Merci d'ajouter ton CV et ta lettre de motivation ci-dessous :</h4><label>Mon CV :</label><input type='file' name='cv' required><label>Ma lettre de Motivation :</label><input type='file' name='motiv' required><input class='sub_postulate' name='sub_postulate' type=submit></form>")
        $.post("stagesession",{titre : titre,description : description,entreprise : entreprise});
    })
})
/*----Bouton de retour en arrière----*/
$(function(){
    $('.btnBack').click(function(){
        window.location="Account";
    })
});
/*----Submit de la recherche sur home.php----*/
$(function(){
    $('.recherche-icone').click(function(){
        $('.form-inline').submit()
    })
})
/*----Ajout d'une compétence dans offre de stage----*/
$(function(){
    $('.add').click(function(){
        if($('.allcompt').val()!=""){
            $('.listing').append($('.allcompt').val() + "; ")
            $('.allcompt').val("")
        }
    })
})
/*----affichage des permissions dans register----*/

$(function(){
    $('.block').hide();
    $('#permission').change(function(){
        if($('#permission').val() == "delegate"){
            $('.block').show();
        }
        else{
            $('.block').hide();
        }
    });
    
});
/*----Affichage complet de l'entreprise----*/ 
$(function(){
    $('.entreprise').click(function(){
        const entreprise = $(this).find('.nom_entreprise').html();
        const identreprise = $(this).find('.identreprise').html();
        $('.affichage_entreprise').html("<form method ='post' class='affichage_entreprise'><h2>" + entreprise + "</h2><textarea name='commentaire' style='height: 90%;width:100%;resize: none;' placeholder='Commentary' required></textarea><input type='hidden' id='idNote' name='note' value='' /><input type='hidden' id='idEntreprise' name='identreprise' value='"+identreprise+"'/> <div class='rating'><input name='stars' id='e5' type='radio' value ='5'></a><label for='e5'>☆</label><input name='stars' id='e4' type='radio' value ='4'></a><label for='e4'>☆</label><input name='stars' id='e3' type='radio' value ='3'></a><label for='e3'>☆</label><input name='stars' id='e2' type='radio' value ='2'></a><label for='e2'>☆</label><input name='stars' id='e1' type='radio' value ='1'></a><label for='e1'>☆</label></div><input class='rate'name='envoiNote' type=submit> </form>");
    })
})
$(function(){
    $('#star1').click(function(){
        $('#idNote').val(1);
        alert('1etoile!!!');
    })
})
$(function(){
    $('#star2').click(function(){
        $('#idNote').val(2);
    })
})
$(function(){
    $('#star3').click(function(){
        $('#idNote').val(3);
    })
})
$(function(){
    $('#star4').click(function(){
        $('#idNote').val(4);
    })
})
$(function(){
    $('#star5').click(function(){
        $('#idNote').val(5);
    })
})


/*----Modifier user----*/
$(function(){
    $('.fa-user-edit').click(function(){

    })
})
/*----supprimer user----*/
$(function(){
    $('.eye').click(function(){
        $(this).toggleClass('fa-eye');
        $(this).toggleClass('fa-eye-slash');
        $nom = $(this).parent().parent().find('.divNom').find('.nom').html()
        $prenom = $(this).parent().parent().find('.divPrenom').find('.prenom').html()
        $age = $(this).parent().parent().find('.divAge').find('.age').html()
        if ($(this).hasClass('fa-eye-slash')){
            $.post("Unvisible",{nom : $nom, prenom : $prenom, age : $age});
        }else{
            $.post("Visible",{nom : $nom, prenom : $prenom, age : $age});
        }
    })
})
/*----Affichage complet du stage----*/ 
$(function(){
    $('.Offre').click(function(){
        const parent = $(this).parent()
        const titre = $(this).find('.titre').html()
        const description = $(this).find('.description').html()
        const entreprise = $(this).find('.entreprise').html()
        const Competences = $(this).find('.idCompetence').html()
        if(parent.children($('.Offre')).hasClass('select')){
            parent.children($('.Offre')).removeClass('select')
            $(this).addClass('select')
        }
        else{
            $(this).addClass('select')
        }
    })
})

/*----Affichage du bouton valider en dessous du form responsive----*/
$(function(){
        if($(window).width() < 769){
            $('.btnAddOver').hide()
            $('.btnAddUnder').show()
        }
        else{
            $('.btnAddOver').show()
            $('.btnAddUnder').hide()
        }
})
