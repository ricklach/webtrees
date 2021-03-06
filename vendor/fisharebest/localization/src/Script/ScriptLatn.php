<?php namespace Fisharebest\Localization\Script;

/**
 * Class ScriptLatn - Representation of the Latin script.
 *
 * @author    Greg Roach <fisharebest@gmail.com>
 * @copyright (c) 2018 Greg Roach
 * @license   GPLv3+
 */
class ScriptLatn extends AbstractScript implements ScriptInterface
{
    public function code()
    {
        return 'Latn';
    }

    public function number()
    {
        return '215';
    }

    public function unicodeName()
    {
        return 'Latin';
    }
}
