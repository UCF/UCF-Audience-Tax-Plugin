/* globals wpLink UCF_AUDIENCE */
/**
 * Function that overrides various wpLink
 * functions so that audiences can be selected
 * for individual links.
 * @author Jim Barnes
 * @since 1.0.0
 * @returns {void}
 */
const addAudienceOption = function () {
  let editor = null;

  if (!editor) {
    const editorId = window.wpActiveEditor;

    // There's no active editor. Bail!
    if (!editorId) {
      return;
    }

    if (typeof window.tinymce !== 'undefined') {
      editor = window.tinymce.get(editorId);
    } else {
      // tinymce is not defined. Bail!
      return;
    }

  }

  /**
   * Reference to the original getAttrs function
   * from wpLink
   * @return {object} The object attributes
   */
  const _getAttrs = wpLink.getAttrs;

  /**
   * Gets the currently active tinymce link being edited.
   * @author Jim Barnes
   * @since 1.0.0
   * @returns {jquery} The jquery object of the currently active link
   */
  const getLink = function () {
    if (editor) {
      return editor.$('a[data-wplink-edit="true"]');
    }

    return null;
  };

  const $link = getLink();
  let $options = null;

  if ($('#wpse-link-audience').length < 1 && UCF_AUDIENCE) {
    $options = $('#link-options').append(UCF_AUDIENCE.wpse_link_audience);
  }

  const $audienceStr = $link.attr('data-set-audience');
  if ($audienceStr.length) {
    const audiences = $audienceStr.split(',');
    for (const audience of audiences) {
      $options.find(`option[value=${audience}]`).attr('selected', true);
    }
  }

  wpLink.getAttrs = function () {
    const retval = _getAttrs();
    retval['data-set-audience'] = $('#wpse-link-audience').val();
    return retval;
  };
};

jQuery(document).on('wplink-open', (wrap) => {
  addAudienceOption(wrap);
});
