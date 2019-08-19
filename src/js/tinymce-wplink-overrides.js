/* globals wpLink ParseUrl UCF_AUDIENCE */
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

  // Get the link so we can get current values.
  const $link = getLink();
  const $options = $('#link-options');

  // This puts the form elements in place
  if ($('#wpse-link-audience').length < 1 && UCF_AUDIENCE) {
    $options.append(UCF_AUDIENCE.wpse_link_audience);
  }

  /**
   * Get the current audience values and set
   * the options to selected for each existing audience
   */
  const $audienceStr = $link.attr('data-set-audience');
  if ($audienceStr && $audienceStr.length) {
    const audiences = $audienceStr.split(',');
    for (const audience of audiences) {
      $options.find(`option[value=${audience}]`).attr('selected', true);
    }
  }

  /**
   * Adds the data-set-audience attribute
   * to the attributes array used to build the link
   * @author Jim Barnes
   * @since 1.0.0
   * @returns {object|array} The attribute object/array
   */
  wpLink.getAttrs = function () {
    const retval = _getAttrs();
    const audience = $('#wpse-link-audience').val();
    const href = new ParseUrl(retval.href);

    if (audience) {
      href.searchObject.audience = audience;
      retval.href = href.buildUrl();
      retval['data-set-audience'] = $('#wpse-link-audience').val();
    }

    return retval;
  };
};

jQuery(document).on('wplink-open', (wrap) => {
  addAudienceOption(wrap);
});
