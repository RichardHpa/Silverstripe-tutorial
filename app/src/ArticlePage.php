<?php
namespace SilverStripe\Lessons;

use SilverStripe\Forms\CheckboxSetField;
use Page;

use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;

use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;

class ArticlePage extends Page{

    private static $can_be_root = false;

    // Creates a database table when you build it
    private static $db = [
        'Date' => 'Date',
        'Teaser' => 'Text',
        'AuthorName' => 'Varchar'
    ];

    private static $has_one = [
        'Photo' => Image::class,
        'Brochure' => File::class
    ];

    // If we dont say this class owns the images, we wont see them unless we are logged in as admins
    private static $owns = [
        'Photo',
        'Brochure',
    ];

    private static $many_many = [
        'Categories' => ArticleCategory::class
    ];

    private static $has_many = [
        'Comments' => ArticleComment::class
    ];

    //Adds a front end form through the admin
    public function getCMSFields(){
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', DateField::create('Date', 'Date of Article'), 'Content');
        $fields->addFieldToTab('Root.Main', TextareaField::create('Teaser')->setDescription('This is the summary that appears on the article list page'), 'Content');
        $fields->addFieldToTab('Root.Main', TextField::create('AuthorName', 'Author of article'), 'Content');

        $fields->addFieldToTab('Root.Attachments', $photo = UploadField::create('Photo'));
        $fields->addFieldToTab('Root.Attachments', $brochure = UploadField::create(
            'Brochure',
            'Travel brochure, optional (PDF only)'
        ));

        $photo->setFolderName('travel-photos');
        $brochure
            ->setFolderName('travel-brochures')
            ->getValidator()->setAllowedExtensions(['pdf']);

        $fields->addFieldToTab(
            'Root.Categories', CheckboxSetField::create(
                'Categories',
                'Selected categories',
                $this->Parent()->Categories()->map('ID', 'Title')
            ));

        return $fields;
    }

    public function CategoiesList(){
        if($this->Categories()->exists()) {
            return implode(',', $this->Categories()->column('Title'));
        }
        return null;
    }

}
