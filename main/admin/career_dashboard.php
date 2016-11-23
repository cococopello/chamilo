<?php
/* For licensing terms, see /license.txt */

/**
 * Careers dashboard
 * @package chamilo.admin.career
 */

$cidReset = true;
require_once __DIR__.'/../inc/global.inc.php';
$libpath = api_get_path(LIBRARY_PATH);

api_protect_admin_script();

$this_section = SECTION_PLATFORM_ADMIN;

//Adds the JS needed to use the jqgrid
$htmlHeadXtra[] = api_get_jqgrid_js();

// setting breadcrumbs
$interbreadcrumb[]=array('url' => 'index.php','name' => get_lang('PlatformAdmin'));
$interbreadcrumb[]=array('url' => 'career_dashboard.php','name' => get_lang('CareersAndPromotions'));

Display :: display_header(null);

$form = new FormValidator('filter_form','GET', api_get_self());

$career = new Career();

$condition = array('status = ?' => 1);
if ($form->validate()) {
    $data = $form->getSubmitValues();
    $filter = intval($data['filter']);
    if (!empty($filter)) {
        $condition = array('status = ? AND id = ? ' => array(1, $filter));
    }
}

$careers = $career->get_all(array('status = ?' => 1)); //only status =1
$career_select_list = array();
$career_select_list[0] = ' -- '.get_lang('Select').' --';
foreach ($careers as $item) {
    $career_select_list[$item['id']] = $item['name'];
}

$form->addSelect(
    'filter',
    get_lang('Career'),
    $career_select_list,
    array('id' => 'filter_1')
);
$form->addButtonSearch(get_lang('Filter'));

// action links
echo '<div class="actions" style="margin-bottom:20px">';
    echo  '<a href="../admin/index.php">'.
            Display::return_icon('back.png', get_lang('BackTo').' '.get_lang('PlatformAdmin'),'',ICON_SIZE_MEDIUM).'</a>';
    echo '<a href="careers.php">'.
            Display::return_icon('career.png',get_lang('Careers'),'',ICON_SIZE_MEDIUM).'</a>';
    echo '<a href="promotions.php">'.
            Display::return_icon('promotion.png',get_lang('Promotions'),'',ICON_SIZE_MEDIUM).'</a>';
echo '</div>';

$form->display();

$careers = $career->get_all($condition); //only status =1

$column_count = 3;
$i = 0;
$grid_js = '';
$career_array = array();
if (!empty($careers)) {
    foreach ($careers as $career_item) {
        $promotion = new Promotion();
        // Getting all promotions
        $promotions = $promotion->get_all_promotions_by_career_id(
            $career_item['id'],
            'name DESC'
        );
        $career_content = '';
        $promotion_array = array();
        if (!empty($promotions)) {
            foreach ($promotions as $promotion_item) {
                if (!$promotion_item['status']) {
                    continue; //avoid status = 0
                }

                // Getting all sessions from this promotion
                $sessions = SessionManager::get_all_sessions_by_promotion(
                    $promotion_item['id']
                );

                $session_list = array();
                foreach ($sessions as $session_item) {
                    $course_list = SessionManager::get_course_list_by_session_id(
                        $session_item['id']
                    );
                    $session_list[] = array(
                        'data' => $session_item,
                        'courses' => $course_list,
                    );
                }
                $promotion_array[$promotion_item['id']] = array(
                    'name' => $promotion_item['name'],
                    'sessions' => $session_list,
                );
            }
        }
        $career_array[$career_item['id']] = array(
            'name' => $career_item['name'],
            'promotions' => $promotion_array,
        );
    }
}

echo '<table class="data_table">';

if (!empty($career_arrayer)) {
    foreach ($career_array as $career_id => $data) {
        $career = $data['name'];
        $promotions = $data['promotions'];
        $career = Display::url($career, 'careers.php?action=edit&id=' . $career_id);
        $career = Display::tag('h4', $career);
        echo '<tr><td style="background-color:#ECF0F1" colspan="3">' . $career . '</td></tr>';
        if (!empty($promotions)) {
            foreach ($promotions as $promotion_id => $promotion) {
                $promotion_name = $promotion['name'];
                $promotion_url = Display::url($promotion_name, 'promotions.php?action=edit&id=' . $promotion_id);
                $sessions = $promotion['sessions'];
                echo '<tr>';
                $count = count($sessions);
                $rowspan = '';
                if (!empty($count)) {
                    $count++;
                    $rowspan = 'rowspan="' . $count . '"';
                }
                echo '<td ' . $rowspan . '>';
                echo Display::tag('h5', $promotion_url);
                echo '</td>';
                echo '</tr>';

                if (!empty($sessions)) {
                    foreach ($sessions as $session) {
                        $course_list = $session['courses'];

                        $url = Display::url($session['data']['name'],
                            '../session/resume_session.php?id_session=' . $session['data']['id']);
                        echo '<tr>';
                        //Session name
                        echo Display::tag('td', $url);
                        echo '<td>';
                        //Courses
                        echo '<table>';
                        if (!empty($course_list)) {
                            foreach ($course_list as $course) {
                                echo '<tr>';

                                $url = Display::url(
                                    $course['title'],
                                    api_get_path(WEB_COURSE_PATH) . $course['directory'] . '/index.php?id_session=' . $session['data']['id']
                                );
                                echo Display::tag('td', $url);
                                echo '</tr>';
                            }
                            echo '</table>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                }
            }
        }
    }
}
echo '</table>';
Display::display_footer();
