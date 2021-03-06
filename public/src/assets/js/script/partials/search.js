/*
 * *
 *  *  Copyright (C) $month.$year | David annebicque | IUT de Troyes - All Rights Reserved
 *  *
 *  *
 *  * @file /Users/davidannebicque/htdocs/intranetv3/assets/js/partials/search.js
 *  * @author     David annebicque
 *  * @project intranetv3
 *  * @date 3/30/19 12:11 PM
 *  * @lastUpdate 3/30/19 12:11 PM
 *  *
 *
 */

$(document).on('keyup', '#search', function (e) {

  const keyword = $(this).val()
  const search_reponse_etudiant = $('#search_reponse_etudiant')
  const search_reponse_personnel = $('#search_reponse_personnel')
  const search_reponse_autre = $('#search_reponse_autre')

  if (keyword.length > 2) {
    $.ajax({
      url: Routing.generate('recherche', {keyword: keyword}),
      dataType: 'json',
      success: function (data) {


        let html = ''
        if (data.etudiants.length > 0) {
          jQuery.each(data.etudiants, function (index, etudiant) {
            html = html + '<a class="media" href="' + Routing.generate('user_profil', {
              type: 'etudiant',
              slug: etudiant.slug
            }) + '" target="_blank">\n'
            if (etudiant.photo === 'noimage.png' || etudiant.photo == null) {
              html = html + '<div class="avatar-circle-sm">\n' +
                '    <span class="initials">' + etudiant.avatarInitiales + '</span>\n' +
                '</div>'
            } else {
              html = html + '<img class="avatar avatar-sm" src="' + data.basepath + 'etudiants/' + etudiant.photo + '" alt="Photo de profil de ' + etudiant.displayPr + '">\n'
            }
            html = html + '                        <div class="media-body">\n' +
              '                            <p><strong>' + etudiant.displayPr + '</strong>\n' +
              '                                <time class="float-right">' + etudiant.groupes + '</time>\n' +
              '                            </p>\n' +
              '                        </div>\n' +
              '                    </a>'
          })
        } else {
          html = '<div class="alert alert-warning">Pas de résultat pour votre rehcerche <strong>"' + keyword + '"</strong></div>'
        }

        search_reponse_etudiant.slideUp().empty().append(html).slideDown()

        html = ''
        if (data.personnels.length > 0) {
          jQuery.each(data.personnels, function (index, personnel) {
            html = html + '<a class="media items-center" href="' + Routing.generate('user_profil', {
              type: 'personnel',
              slug: personnel.slug
            }) + '" target="_blank">\n'
            if (personnel.photo === 'noimage.png' || personnel.photo == null) {
              html = html + '<div class="avatar-circle-sm">\n' +
                '    <span class="initials">' + personnel.avatarInitiales + '</span>\n' +
                '</div>'
            } else {
              html = html + '<img class="avatar avatar-sm" src="' + data.basepath + 'personnels/' + personnel.photo + '" alt="Photo de profil de ' + personnel.displayPr + '">\n'
            }
            html = html + '                        <p>' + personnel.displayPr + '</p>\n' +
              '</a>'
          })
        } else {
          html = '<div class="alert alert-warning">Pas de résultat pour votre rehcerche <strong>"' + keyword + '"</strong></div>'
        }
        search_reponse_personnel.slideUp().empty().append(html).slideDown()

        html = ''
        if (data.autres.length > 0) {
          jQuery.each(data.autres, function (index, autre) {
            html = html + '<a class="media items-center" href="">\n' +
              '                        <img class="avatar avatar-sm" src="../assets/img/avatar/1.jpg" alt="...">\n' +
              '                        <p>' + autre + '</p>\n' +
              '                    </a>'
          })
        } else {
          html = '<div class="alert alert-warning">Pas de résultat pour votre rehcerche <strong>"' + keyword + '"</strong></div>'
        }
        search_reponse_autre.slideUp().empty().append(html).slideDown()
      }
    })
  } else {
    var html = '<div class="alert alert-info">Saisir au moins 3 caractères</div>'
    search_reponse_autre.slideUp().empty().append(html).slideDown()
    search_reponse_personnel.slideUp().empty().append(html).slideDown()
    search_reponse_etudiant.slideUp().empty().append(html).slideDown()
  }
})
