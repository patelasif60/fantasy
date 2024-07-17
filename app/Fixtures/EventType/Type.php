<?php

namespace App\Fixtures\EventType;

use App\Fixtures\TypeInterface;
use Form;
use Illuminate\Http\Request;
use JsonSerializable;

class Type implements JsonSerializable
{
    //Bind Variables
    protected $field_settings;
    protected $key;
    protected $attributes = ['class'=>'form-control'];

    // Prepares the select element of the html
    public function getSelectHtml($name, $title, $options = [])
    {
        $values = [];
        $selected = '';
        $attr = [];
        if (! empty($options)) {
            $values = ! empty($options['values']) ? $options['values'] : [];
            $selected = ! empty($options['selected']) ? $options['selected'] : '';
            $attr = ! empty($options['attr']) ? $options['attr'] : [];
        }
        $attr += $this->attributes;
        $label = Form::label($name, $title)->toHtml();
        $select = Form::select($name, $values, $selected, $attr)->toHtml();

        return $label.$select;
    }

    // Prepares the html for the type if event selected
    public function getHtml($field, $event_clubs, $event_selected_club = '', $event_details = '')
    {
        $values = [''=>'Select a player'];
        $attr = ['data-obj'=>json_encode($field), 'data-rules'=>json_encode($this->rules($field['name'])), 'class'=>'form-control '.$this->key];
        $selected = '';
        if ($field['data'] == 'player_all') {
            $home = $event_clubs['home']->pluck('player.full_name', 'player.id')->all();
            $away = $event_clubs['away']->pluck('player.full_name', 'player.id')->all();
            $all = $home + $away;
            ksort($all);
            $values += $all;
            if (! empty($event_selected_club) && ! empty($event_details)) {
                $current_field = array_search($field['name'], array_column($event_details->toArray(), 'field'));
                if (! empty($current_field) || $current_field == 0) {
                    $selected = ($event_details->toArray())[$current_field]['field_value'];
                }
            }
        } elseif ($field['data'] == 'player' && ! empty($event_selected_club) && ! empty($event_details)) {
            $values += $event_clubs[$event_selected_club->type]->pluck('player.full_name', 'player.id')->all();
            $current_field = array_search($field['name'], array_column($event_details->toArray(), 'field'));
            if (! empty($current_field) || $current_field === 0) {
                $selected = ($event_details->toArray())[$current_field]['field_value'];
            }
        }
        $html_method = 'get'.ucfirst($field['input']).'Html';
        if (method_exists($this, $html_method)) {
            return $this->$html_method($field['name'], $field['title'], [
                'values'=>$values,
                'selected'=>$selected,
                'attr'=>$attr,
            ]);
        }

        return '';
    }

    // Prepare the data to save into the database
    public function prepareForSave(Request $request, $event_id)
    {
        $data = [];
        foreach ($this->field_settings as $key => $value) {
            if (! empty($request[$key])) {
                $data[] = [
                    'event_id'      => $event_id,
                    'field'         => $key,
                    'field_value'   => $request[$key],
                ];
            }
        }

        return $data;
    }

    // Get the field settings for the event type
    public function getFieldSettings()
    {
        return $this->field_settings;
    }

    // Set the key for the event type
    public function setKey($key)
    {
        $this->key = $key;
    }

    // Get the key for the event type
    public function getKey()
    {
        return $this->key;
    }

    // function for the implemented JSONSerializer
    public function jsonSerialize()
    {
        return $this->field_settings + $this->rules();
    }

    public function calculate_event_points($event_count)
    {
        return $this->points * $event_count;
    }
}
