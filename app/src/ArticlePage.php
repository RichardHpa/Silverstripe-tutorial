<?php
namespace SilverStripe\Lessons;

use Page;

use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;

class ArticlePage extends Page{
    private static $can_be_root = false;

    // Creates a database table when you build it
    private static $db = [
        'Date' => 'Date',
        'Teaser' => 'Text',
        'AuthorName' => 'Varchar'
    ];

    //Adds a front end form through the admin
    public function getCMSFields(){
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', DateField::create('Date', 'Date of Article'), 'Content');
        $fields->addFieldToTab('Root.Main', TextareaField::create('Teaser')->setDescription('This is the summary that appears on the article list page'), 'Content');
        $fields->addFieldToTab('Root.Main', TextField::create('AuthorName', 'Author of article'), 'Content');

        return $fields;
    }


}
