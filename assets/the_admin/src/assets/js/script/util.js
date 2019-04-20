/*
 * *
 *  *  Copyright (C) $month.$year | David annebicque | IUT de Troyes - All Rights Reserved
 *  *
 *  *
 *  * @file /Users/davidannebicque/htdocs/intranetv3/assets/the_admin/src/assets/js/script/util.js
 *  * @author     David annebicque
 *  * @project intranetv3
 *  * @date 3/30/19 12:08 PM
 *  * @lastUpdate 3/30/19 12:07 PM
 *  *
 *
 */

function readUrlMenu ($url) {
  var $elt = $url.split('/')
  var $firstElt = 2
  console.log($elt)
  if ($elt[1] === 'index.php') {
    if ($elt.length > 1) {
      $firstElt = 3
    }
  }

  if ($elt[$firstElt] === 'super-administration') {
    $firstElt = $firstElt + 1
  }

  if ($elt[$elt.length - 1] === '') {
    $elt.pop()
  }

  $('.menu-item').removeClass('active')
  $('#menu-' + $elt[$firstElt]).addClass('active')
}

//pop up de confirmation de suppression
$(document).on('click', '.supprimer', function (e) {
  e.preventDefault()
  var url = $(this).attr('href')
  var csrf = $(this).data('csrf')
  swal({
    title: 'Are you sure?',
    text: 'You won\'t be able to revert this!',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel!',
    confirmButtonClass: 'btn btn-primary',
    cancelButtonClass: 'btn btn-secondary',
    buttonsStyling: false
  }).then(function (result) {
    console.log(result)
    if (result.value) {
      console.log(url)
      $.ajax({
        url: url,
        type: 'DELETE',
        data: {
          _token: csrf
        },
        success: function (id) {
          $('#ligne_' + id).closest('tr').remove()
          addCallout('Suppression effectuée avec succès', 'success')
          swal(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        },
        error: function (xhr, ajaxOptions, thrownError) {
          swal('Error deleting!', 'Please try again', 'error')
          addCallout('Erreur lors de la tentative de suppression', 'danger')
        }
      })

    } else if (
      // Read more about handling dismissals
      result.dismiss === 'cancel'
    ) {
      swal(
        'Cancelled',
        'Your imaginary file is safe :)',
        'error'
      )
    }
  })
})

function addCallout (message, label) {
  var html = '<div class="callout callout-' + label + '" role="alert">\n' +
    '                    <button type="button" class="close" data-dismiss="callout" aria-label="Close">\n' +
    '                        <span>&times;</span>\n' +
    '                    </button>\n' +
    '                    <h5>' + label + '</h5>\n' +
    '                    <p>' + message + '</p>\n' +
    '                </div>'

  $('#mainContent').prepend(html).slideDown('slow')
  $('.callout').delay(5000).slideUp('slow')
}
