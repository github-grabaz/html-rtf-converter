<?php

namespace HtmlToRtf\Node\ElementNode;

use HtmlToRtf\Node\ElementNode;

/**
 * Class PElementNode
 * @package HtmlToRtf\Node\ElementNode
 */
class H1ElementNode extends ElementNode
{
    /**
     * parse node and create RTF string
     * @return string
     */
    public function parse()
    {
        $prepend = '{\pard\sa200\sl276\slmult1';
        $prepend .= '\f0\cf1\fs' . 40 . ' ';
        $append = '\par}';

        $css = $this->getAttribute('style');
        $css = strtolower($css);

        $styles = preg_split('/;/', $css);
        $styles = array_map('trim', $styles);
        foreach ($styles as $styleDef) {
            if (empty($styleDef)) {
                continue;
            }

            $style = preg_split('/:/', $styleDef);
            $style = array_map('trim', $style);
            switch ($style[0]) {
                case 'text-align':
                    switch ($style[1]) {
                        case 'left':
                            $prepend = $prepend . '\ql';
                            break;

                        case 'right':
                            $prepend = $prepend . '\qr';
                            break;

                        case 'justify':
                            $prepend = $prepend . '\qj';
                            break;

                        case 'center':
                            $prepend = $prepend . '\qc';
                            break;
                    }
                    break;
            }
        }
        $this->setRtfPrepend($prepend . ' ');
        $this->setRtfAppend($append);

        return parent::parse();
    }
}
