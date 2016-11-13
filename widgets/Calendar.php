<?php

/*
 * <?= \app\widgets\Calendar::widget() ?>
 */


namespace app\widgets;

use yii\helpers\Html;
use yii\base\Widget;

class Calendar extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run() {

        $months = [
            0 => 'Январь',
            1 => 'Февраль',
            2 => 'Март',
            3 => 'Апрель',
            4 => 'Май',
            5 => 'Июнь',
            6 => 'Июль',
            7 => 'Август',
            8 => 'Сентябрь',
            9 => 'Октябрь',
            10 => 'Ноябрь',
            11 => 'Декабрь'
        ];
        $time = time();
        $request = \Yii::$app->request;
        $time = $request->get('time', $time);
        $month = date('n', $time);
        $year = date('Y', $time);

        echo '<div class="b-calendar b-calendar--along">';
        echo '<h4 class="text-center">';
        echo Html::a(Html::icon('triangle-left'), '?time='.strtotime('-1 month', $time), ['class'=>'pull-left']);
        echo $months[$month-1] .'&nbsp;' . $year;
        echo Html::a(Html::icon('triangle-right'), '?time='.strtotime('+1 month', $time), ['class'=>'pull-right']);
        echo '</h4>';
        echo $this->draw_calendar($month,2016);

        echo '</div>';
    }

    public function draw_calendar($month, $year, $action = 'none') {
        $calendar = '<table cellpadding="0" cellspacing="0" class="b-calendar__tb">';

        // вывод дней недели
        $headings = array('Пн','Вт','Ср','Чт','Пт','Сб','Вс');
        $calendar.= '<tr class="b-calendar__row">';
        for($head_day = 0; $head_day <= 6; $head_day++) {
            $calendar.= '<th class="b-calendar__head';
            // выделяем выходные дни
            if ($head_day != 0) {
                if (($head_day % 5 == 0) || ($head_day % 6 == 0)) {
                    $calendar .= ' b-calendar__weekend';
                }
            }
            $calendar .= '">';
            $calendar.= '<div class="b-calendar__number">'.$headings[$head_day].'</div>';
            $calendar.= '</th>';
        }
        $calendar.= '</tr>';
        // выставляем начало недели на понедельник
        $running_day = date('w',mktime(0,0,0,$month,1,$year));
        $running_day = $running_day - 1;
        if ($running_day == -1) {
            $running_day = 6;
        }

        $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
        $day_counter = 0;
        $days_in_this_week = 1;
        $dates_array = array();

        // первая строка календаря
        $calendar.= '<tr class="b-calendar__row">';

        // вывод пустых ячеек
        for ($x = 0; $x < $running_day; $x++) {
            $calendar.= '<td class="b-calendar__np"></td>';
            $days_in_this_week++;
        }

        // дошли до чисел, будем их писать в первую строку
        for($list_day = 1; $list_day <= $days_in_month; $list_day++) {
            $calendar.= '<td class="b-calendar__day';
            // выделяем сегодня
            if (date('Ynj') == $year.$month.($list_day)) {
                $calendar .= ' b-calendar__today';
            }
            if ($running_day != 0) {
                // выделяем выходные дни
                if (($running_day % 5 == 0) || ($running_day % 6 == 0)) {
                    $calendar .= ' b-calendar__weekend';
                }
            }
            $calendar .= '">';
            // пишем номер в ячейку
            $calendar.= '<div class="b-calendar__number">'.$list_day.'</div>';
            $calendar.= '</td>';
            // дошли до последнего дня недели
            if ($running_day == 6) {
                // закрываем строку
                $calendar.= '</tr>';
                // если день не последний в месяце, начинаем следующую строку
                if (($day_counter + 1) != $days_in_month) {
                    $calendar.= '<tr class="b-calendar__row">';
                }
                // сбрасываем счетчики
                $running_day = -1;
                $days_in_this_week = 0;
            }
            $days_in_this_week++;
            $running_day++;
            $day_counter++;
        }
        // выводим пустые ячейки в конце последней недели
        if ($days_in_this_week < 8) {
            for($x = 1; $x <= (8 - $days_in_this_week); $x++) {
                $calendar.= '<td class="b-calendar__np"> </td>';
            }
        }
        $calendar.= '</tr>';
        $calendar.= '</table>';
        return $calendar;
    }





}