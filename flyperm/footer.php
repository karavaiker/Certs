          </div>
        </div>
      </div>

      <div class="bWrap">
        <div id="footer">
          <div class="pad">
          <!-- <span id="vkontakte">
            <a href="http://vkontakte.ru/club10637709" target="_blank">Vkontakte</a>
          </span>
          <span id="youtube">
            <a href="http://www.youtube.com/user/89028015774" target="_blank">You Tube</a>
          </span>
          <span id="insales">
            <a href="http://paraplan.myinsales.ru/" target="_blank">InSales</a>
          </span>
          
          <iframe src="http://www.facebook.com/plugins/like.php?app_id=114370028648742&amp;href=<?= $href ?>&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:24px; position:absolute; left: 325px; top: 15px;" allowTransparency="true"></iframe>
            -->
            <div class="social">
              <ul>
                <li>
                  <script type="text/javascript" src="http://vkontakte.ru/js/api/share.js?11"></script>
                  <script type="text/javascript">document.write(VK.Share.button(false,{type: "round_nocount", text: "Мне нравится"}));</script>
                </li>
                <li>
                  <div id="fb-root"></div>
                  <script>(function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
                  }(document, 'script', 'facebook-jssdk'));</script>
                  <div class="fb-like" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
                </li>
                <li>
                  <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-lang="ru">Твитнуть</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
                </li>
              </ul>
            </div>
			<div class="bottom-menu">
              <?php
              $menu = wp_get_nav_menu_object('bottom'); // получаем нижнее меню
              $current_url = home_url($wp->request).'/'; // url страницы

              $menu_list = '';
              $menu_items = wp_get_nav_menu_items($menu->term_id); // получаем элементы по ID  

              foreach ((array) $menu_items as $key => $item) {
                
                $active_class = ($current_url == $item->url) ? 'class = "active"' : '';
                $menu_list .= '<a href="' . $item->url . '" id="m' . ($key + 1) . '" ' . $active_class . '>' . $item->title . '</a>&nbsp;|&nbsp;';
              }

              echo $menu_list;
              ?> 
            </div>
            <div class="infoBottom">По вопросам организации полетов звоните Алексею Иванову  <span>(342) 277-57-74</span></div>
            <div class="yandexMoney">
              <a href="https://money.yandex.ru" target="_blank"> 
                <img src="https://money.yandex.ru/img/yamoney_logo88x31.gif" alt="Я принимаю Яндекс.Деньги" title="Я принимаю Яндекс.Деньги" border="0" width="88" height="31"/>
              </a>
            </div>
            <div class="webMoney">
              <a href="http://www.webmoney.ru/" target="_blank"> 
                <img src="/pics/webmoney.png" alt="Мы принимаем WebMoney" title="Мы принимаем WebMoney" border="0" width="88" height="31"/>
              </a>
            </div>
          </div>
        </div>
        <div class="bottom png24"></div>

    
      </div>

      <!-- Yandex.Metrika counter -->
      <div style="display:none;"><script type="text/javascript">
      (function(w, c) {
        (w[c] = w[c] || []).push(function() {
          try {
            w.yaCounter8029822 = new Ya.Metrika({id:8029822, enableAll: true});
          }
          catch(e) { }
        });
      })(window, "yandex_metrika_callbacks");
        </script></div>
      <script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
      <noscript><div><img src="//mc.yandex.ru/watch/8029822" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
      <!-- /Yandex.Metrika counter -->

      <!-- Google.Analytics counter -->
      <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-24621483-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
      </script>
      <!-- /Google.Analytics counter -->
    </div>
  </body>
</html>