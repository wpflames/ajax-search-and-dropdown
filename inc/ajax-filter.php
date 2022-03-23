<?php
// Shortcode: [my_ajax_filter_search]
function my_ajax_filter_search_shortcode() {
    ob_start(); 

    my_ajax_filter_search_scripts(); // Added here ?>
 
    <div id="my-ajax-filter-search">
        <form action="" method="get">
            <div class="grid grid-3">

                <div class="grid-item">
                    <label for="search">Search by name</label>
                    <input type="text" name="search" id="search" value="" placeholder="Search Here..">
                </div>

                <div class="grid-item">
                    <label for="year">Academic Year</label>
                    
                    <?php
                        if( $terms = get_terms( array( 'taxonomy' => 'ay', 'orderby' => 'name' ) ) ) : 

                            echo '<select id="year" name="year"><option value="">Select ...</option>';
                            foreach ( array_reverse($terms) as $term ) :
                                echo '<option value="' . $term->slug . '">' . $term->name . '</option>'; 
                            endforeach;
                            echo '</select>';
                        endif;
                    ?>
                </div>

                <div class="grid-item">
                    <label for="status">Grant Category</label>
                    <select name="status" id="status">
                        <option value="">Select ...</option>
                        <option value="lecturer">Lecturer</option>
                        <option value="researcher">Researcher</option>
                        <option value="student">Student</option>
                    </select>
                </div>
            </div>
 
            <input type="submit" id="submit" name="submit" value="Search">
        </form>
        <div id="ajax_fitler_search_results" class="cards grid grid-2"></div>
    </div>
     
    <?php
    return ob_get_clean();
}
 
add_shortcode ('my_ajax_filter_search', 'my_ajax_filter_search_shortcode');