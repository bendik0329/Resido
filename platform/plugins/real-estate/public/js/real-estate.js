/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************************************************!*\
  !*** ./platform/plugins/real-estate/resources/assets/js/real-estate.js ***!
  \*************************************************************************/
$(document).ready(function () {
  $(document).on('change', '#type_id', function (event) {
    if ($('#type_id').children('option:selected').data('code') == 'rent') {
      $('#period').closest('.period-form-group').removeClass('hidden').fadeIn();
    } else {
      $('#period').closest('.period-form-group').addClass('hidden').fadeOut();
    }
  });
  $(document).on('change', '#never_expired', function (event) {
    if ($(event.currentTarget).is(':checked') === true) {
      $('#auto_renew').closest('.auto-renew-form-group').addClass('hidden').fadeOut();
    } else {
      $('#auto_renew').closest('.auto-renew-form-group').removeClass('hidden').fadeIn();
    }
  });
  $(document).on('change', '#auto_renew', function (event) {
    if ($(event.currentTarget).is(':checked') === true) {
      $(".renew_cost").removeClass('hidden').fadeIn();
    } else {
      $('.renew_cost').addClass('hidden').fadeOut();
    }
  });
  $(document).on('click', '.button-renew', function (event) {
    event.preventDefault();

    var _self = $(event.currentTarget);

    Botble.showError("asdfasdfsadf");
    $('.button-confirm-renew').data('section', _self.data('section')).data('parent-table', _self.closest('.table').prop('id'));
    $('.modal-confirm-renew').modal('show');
  });
  $('.button-confirm-renew').on('click', function (event) {
    event.preventDefault();

    var _self = $(event.currentTarget);

    var url = _self.data('section');

    _self.addClass('button-loading');

    $.ajax({
      url: url,
      type: 'POST',
      success: function success(data) {
        if (data.error) {
          Botble.showError(data.message);
        } else {
          window.LaravelDataTables[_self.data('parent-table')].row($('a[data-section="' + url + '"]').closest('tr')).remove().draw();

          Botble.showSuccess(data.message);
        }

        _self.closest('.modal').modal('hide');

        _self.removeClass('button-loading');
      },
      error: function error(data) {
        Botble.handleError(data);

        _self.removeClass('button-loading');
      }
    });
  });
  $('body').on('change', '#property-category', function () {
    var _this = $(this);

    if ($('#property-sub-category').length < 1) {
      return;
    }

    $.ajax({
      url: _this.data('url'),
      data: {
        id: _this.val()
      },
      beforeSend: function beforeSend() {
        $('#property-sub-category').html('<option value="">' + $('#property-sub-category').data('placeholder') + '</option>');
      },
      success: function success(data) {
        var option = '<option value="">' + $('#property-sub-category').data('placeholder') + '</option>';
        $.each(data.data, function (index, item) {
          option += '<option value="' + item.id + '">' + item.name + '</option>';
        });
        $('#property-sub-category').html(option).select2();
      }
    });
  }).on('change', 'select#filter_country_id', function () {
    var _this = $(this);

    $.ajax({
      url: $('#filter_state_id').data('url'),
      data: {
        id: _this.val()
      },
      beforeSend: function beforeSend() {
        $('#filter_state_id').html('<option value="">' + $('#filter_state_id').data('placeholder') + '</option>');
        $('#filter_city_id').html('<option value="">' + $('#filter_city_id').data('placeholder') + '</option>');
      },
      success: function success(data) {
        var option = '<option value="">' + $('#filter_state_id').data('placeholder') + '</option>';
        $.each(data.data, function (index, item) {
          option += '<option value="' + item.id + '">' + item.name + '</option>';
        });
        $('#filter_state_id').html(option).select2();
      }
    });
  }).on('change', 'select#filter_state_id', function () {
    var _this = $(this);

    $.ajax({
      url: $('#filter_city_id').data('url'),
      data: {
        id: _this.val()
      },
      beforeSend: function beforeSend() {
        $('#filter_city_id').html('<option value="">' + $('#filter_city_id').data('placeholder') + '</option>');
      },
      success: function success(data) {
        var option = '<option value="">' + $('#filter_city_id').data('placeholder') + '</option>';
        $.each(data.data, function (index, item) {
          option += '<option value="' + item.id + '">' + item.name + '</option>';
        });
        $('#filter_city_id').html(option).select2();
      }
    });
  });
});
/******/ })()
;