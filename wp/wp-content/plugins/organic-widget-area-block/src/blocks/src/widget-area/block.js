// Import css
import './css/editor.scss'
import './css/style.scss'

import {WidgetAreaIconColor} from './components/icons'
// Import Editor components
import {
  ContentPlaceholder,
  Header,
  Description,
  InputButtons,
  CustomizerButton
} from './components/editor'

const {__} = wp.i18n
const {registerBlockType} = wp.blocks

const {
  BlockControls,
  AlignmentToolbar,
} = wp.editor;

// Register Block
registerBlockType('organic/widget-area', {
  title: __('Widget Area'),
  description: __('Add a Widget Area anywhere in your page/post.'),
  icon: WidgetAreaIconColor,
  category: 'widgets',
  keywords: [
    __('Organic Widget Area')
  ],
  supports: {
    html: false
    // align: [ 'wide', 'full' ]
  },
  attributes: {
    widget_area_title: {
      type: 'string',
      default: ''
    },
    isSaved: {
      type: 'string',
      default: ''
    }
  },

  edit ({className, attributes, setAttributes}) {
    let content = __('Enter a name for the Widget Area, then enter the Customizer to add Widgets.')

    function onChange(event) {
      setAttributes({widget_area_title: event.target.value})
    }

    if (attributes.widget_area_title !== '') {
      content = __('Enter the Customizer to add Widgets to this area.')
    }

    return (
      <ContentPlaceholder>
        <Header />
        <Description
          content={content}
        />
        <InputButtons
          widget_area_title={attributes.widget_area_title}
          onChange={(event) => {
            setAttributes({widget_area_title: event.target.value})
          }}
          onClick={() => {
            jQuery('.editor-post-publish-button,.editor-post-publish-panel__toggle').trigger('click')
          }}
        />
        <CustomizerButton
          widget_area_title={attributes.widget_area_title}
        />
      </ContentPlaceholder>
    )
  },

  save ({className, attributes}) {
    // We're going to render this block using PHP
    // Return null
    return null
  }
})
