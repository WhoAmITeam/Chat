<?php
function show_time($t){
    list($date, $time) = explode(' ', $t);
                list($year, $month, $day) = explode('-', $date);
                list($hour, $minute, $second) = explode(':', $time);
                $mo = '';
                        if($month == '01'){
                            $mo = 'Января';
                        }
                        if($month == '02'){
                            $mo = 'Февраля';
                        }
                        if($month == '03'){
                            $mo = 'Марта';
                        }
                        if($month == '04'){
                            $mo = 'Апреля';
                        }
                        if($month == '05'){
                            $mo = 'Мая';
                        }
                        if($month == '06'){
                            $mo = 'Июня';
                        }
                        if($month == '07'){
                            $mo = 'Июля';
                        }
                        if($month == '08'){
                            $mo = 'Августа';
                        }
                        if($month == '09'){
                            $mo = 'Сентября';
                        }
                        if($month == '10'){
                            $mo = 'Октября';
                        }
                        if($month == '11'){
                            $mo = 'Ноября';
                        }
                        if($month == '12'){
                            $mo = 'Декабря';
                        }
                if($year == date('Y')){
                    if($month == date('m')){
                        if($day == date('d')){
                            if($hour == date('H')){
                                if($minute == date('i')){
                                    if($second + 20 > date('s')){
                                        echo 'Прямо сейчас!';
                                    }else{
                                        echo date('s') - $second . ' секунд назад';
                                    }
                                }else{
                                    echo date('i') - $minute . ' минут назад';
                                }
                            }else{
                                echo 'Сегодня в ' . $hour . ':' . $minute;
                            }
                        }else if($day + 1 == date('d')){
                            echo 'Вчера в ' . $hour . ':' . $minute;
                        }else{
                            echo $day . ' числа в ' . $hour . ':' . $minute;
                        }
                       
                    }else{
                        echo $day . ' ' . $mo . ' в ' . $hour . ':' . $minute;
                    }
                   
                }else{
                    echo $year . ' год, ' . $day . ' ' . $mo . ' в ' . $hour . ':' . $minute;
                }
}
?>