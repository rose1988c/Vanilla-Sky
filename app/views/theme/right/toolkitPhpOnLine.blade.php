@section('title', $title) 

@section('breadcumb')
    @include('theme.right.breadcumb')
@stop

@section('content')
    <section id="content" class="clearfix">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
    <h3>
            请在下方输入PHP代码:
    </h3>
        <form action="" method="POST">
            <textarea cols="100" rows="20" name="content"><?php if (isset($_POST['content'])) { echo stripcslashes($_POST['content']); } else { echo '<?php echo \'hello baby\';?>'; } ?></textarea>
            <br/>
            <input type="submit" name="reset" value="执行"/>
        </form>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
    <h3>
            执行结果:
    </h3>
    <?php   
//         if (isset($_POST['content'])) {
//             print_r(eval(stripcslashes($_POST['content'])));
//         }
        
        if(!empty($_POST)){
            if(get_magic_quotes_gpc())
                highlight(eval_php(stripslashes($_POST['content'])));
            else{
                highlight(eval_php($_POST['content']));
            }
        }
        function eval_php($content)
        {
            ob_start();
            
            if (strpos($content, '<?php') === false){
                $content = '<?php ' . $content;
            }
            if (strpos($content, '?>') === false){
                $content .= '?>';
            }
            
            eval("?>$content<?php ");
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        }
        function highlight($content){
            echo '<pre>';
            echo '<code>';
            echo $content;
            echo '</code>';
            echo '</pre>';
        }
    ?>
    <br/>
    </div>
    </section>
@stop

@section('footer')
<!--Pageviews-->
{{ HTML::script('assets/theme_right/js/highlight/highlight.js') }}
{{ HTML::style('assets/theme_right/js/highlight/styles/monokai_sublime.css') }}
<!--PageViews-->
@stop