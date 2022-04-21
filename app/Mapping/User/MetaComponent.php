<?php

namespace App\Mapping\User;

use Yonna\Mapping\Mapping;

class MetaComponent extends Mapping
{

    const INPUT_STRING = 'input_string';
    const INPUT_NUMBER = 'input_number';
    const INPUT_PASSWORD = 'input_password';
    const RANGE_PICKER_DATE = 'range_picker_date';
    const RANGE_PICKER_DATETIME = 'range_picker_datetime';
    const RANGE_PICKER_TIME = 'range_picker_time';
    const PICKER_DATE = 'picker_date';
    const PICKER_DATETIME = 'picker_datetime';
    const PICKER_TIME = 'picker_time';
    const PICKER_WEEK = 'picker_week';
    const PICKER_MONTH = 'picker_month';
    const PICKER_QUARTER = 'picker_quarter';
    const PICKER_YEAR = 'picker_year';
    const CASCADER = 'cascader';
    const CASCADER_REGION = 'cascader_region';
    const CASCADER_PROVINCIAL = 'cascader_provincial';
    const CASCADER_MUNICIPAL = 'cascader_municipal';
    const SELECT = 'select';
    const CHECKBOX = 'checkbox';
    const RADIO = 'radio';
    const XOSS_UPLOAD_IMAGE = 'xoss_upload_image';
    const XOSS_UPLOAD_IMAGE_CROP = 'xoss_upload_image_crop';


    public function __construct()
    {
        self::setLabel(self::INPUT_STRING, 'input_string');
        self::setLabel(self::INPUT_NUMBER, 'input_number');
        self::setLabel(self::INPUT_PASSWORD, 'input_password');
        self::setLabel(self::RANGE_PICKER_DATE, 'range_picker_date');
        self::setLabel(self::RANGE_PICKER_DATETIME, 'range_picker_datetime');
        self::setLabel(self::RANGE_PICKER_TIME, 'range_picker_time');
        self::setLabel(self::PICKER_DATE, 'picker_date');
        self::setLabel(self::PICKER_DATETIME, 'picker_datetime');
        self::setLabel(self::PICKER_TIME, 'picker_time');
        self::setLabel(self::PICKER_WEEK, 'picker_week');
        self::setLabel(self::PICKER_MONTH, 'picker_month');
        self::setLabel(self::PICKER_QUARTER, 'picker_quarter');
        self::setLabel(self::PICKER_YEAR, 'picker_year');
        self::setLabel(self::CASCADER, 'cascader');
        self::setLabel(self::CASCADER_REGION, 'cascader_region');
        self::setLabel(self::CASCADER_PROVINCIAL, 'cascader_provincial');
        self::setLabel(self::CASCADER_MUNICIPAL, 'cascader_municipal');
        self::setLabel(self::SELECT, 'select');
        self::setLabel(self::CHECKBOX, 'checkbox');
        self::setLabel(self::RADIO, 'radio');
        self::setLabel(self::XOSS_UPLOAD_IMAGE, 'xoss_upload_image');
        self::setLabel(self::XOSS_UPLOAD_IMAGE_CROP, 'xoss_upload_image_crop');
    }

}