<?php

$PluginInfo['tagsInMeta'] = [
    'Name' => 'Tags in Meta',
    'Description' => 'Show discussions tags in discussions meta area',
    'Version' => '0.2',
    'RequiredApplications' => ['Vanilla' => '>=2.3'],
    'RequiredPlugins' => ['Tagging' => '>=1.8'],
    'MobileFriendly' => true,
    'HasLocale' => true,
    'Author' => 'Robin Jurinka',
    'AuthorUrl' => 'open.vanillaforums.com/profile/r_j',
    'License' => 'MIT'
];

class TagsInMetaPlugin extends Gdn_Plugin {
    /**
     * Show information in /categories pages.
     *
     * @param CategoriesController $sender Instance of the calling class.
     * @param mixed $args Event Arguments.
     *
     * @return void.
     */
    public function categoriesController_discussionMeta_handler($sender, $args) {
        $this->showTags($sender, $args);
    }

    /**
     * Show information in "Recent Discussion".
     *
     * @param DiscussionsController $sender Instance of the calling class.
     * @param mixed $args Event Arguments.
     *
     * @return void.
     */
    public function discussionsController_discussionMeta_handler($sender, $args) {
        $this->showTags($sender, $args);
    }

    private function showTags($sender, $args) {
        if (!$args['Discussion']->Tags) {
            // No tags, nothing to do.
            return;
        }
        // Add css to page.
        $sender->addCssFile('tagsinmeta.css', 'plugins/tagsInMeta');

        foreach ($args['Discussion']->Tags as $tag) {
            $tagname = htmlEsc($tag['FullName']);
            $htmlOut .= '<span class="Tag Tag-'.ucfirst($tagname).'">'.$tagname.'</span> ';
        }
        echo '<span class="MItem Tags">'.trim($htmlOut).'</span>';
    }
}
