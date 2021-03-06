/*
 * *
 *  *  Copyright (C) $month.$year | David annebicque | IUT de Troyes - All Rights Reserved
 *  *
 *  *
 *  * @file /Users/davidannebicque/htdocs/intranetv3/assets/js/partials/planning.js
 *  * @author     David annebicque
 *  * @project intranetv3
 *  * @date 3/30/19 12:11 PM
 *  * @lastUpdate 3/30/19 12:11 PM
 *  *
 *
 */

$(document).on('click', '.filtreTypeDate', function (e) {
  const btn = $(this)
  const type = btn.data('type')
  if (btn.hasClass('btn-outline')) {
    afficheType(type)
    btn.removeClass('btn-outline')
  } else {
    btn.addClass('btn-outline')
    removeType(type)

  }
})

$(document).on('click', '.filtreUtilisateurDate', function (e) {
  const btn = $(this)
  const type = btn.data('type')
  if (btn.hasClass('btn-outline')) {
    afficheUtilisateur(type)
    btn.removeClass('btn-outline')
  } else {
    btn.addClass('btn-outline')
    removeUtilisateur(type)

  }
})

//todo: croiser les filtres.
function removeType (type) {
  $('.event').each(function (e) {
    if ($(this).data('type-event') === type) {
      $(this).hide()
    }
  })
}

function afficheType (type) {
  $('.event').each(function (e) {
    if ($(this).data('type-event') === type) {
      $(this).show()
    }
  })
}

function removeUtilisateur (type) {
  if (type === 'E') {
    $('.event').each(function (e) {
      if ($(this).data('qui-event') === type) {
        $(this).hide()
      }
    })
  } else {
    $('.event').each(function (e) {
      if ($(this).hasClass(type)) {
        $(this).hide()
      }
    })
  }
}

function afficheUtilisateur (type) {
  if (type === 'E') {
    $('.event').each(function (e) {
      if ($(this).data('qui-event') === type) {
        $(this).show()
      }
    })
  } else {
    $('.event').each(function (e) {
      if ($(this).hasClass(type)) {
        $(this).show()
      }
    })
  }
}

$(document).on('change', '#semaine', function(e){
  e.preventDefault()
  //{{ edt.filtre }}_{{ edt.valeur }}_{{ sem.semaineReelle}}
  let tab = $(this).val().split('_')
  location.href = Routing.generate('agenda_index', {semaine: tab[2] ,valeur: tab[1],  filtre: tab[0]});
})
