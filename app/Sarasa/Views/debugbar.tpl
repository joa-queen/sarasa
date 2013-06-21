        <style type="text/css">
        footer {
            margin-bottom: 3em;
        }
        #sarasadebugbar {
            position: fixed;
            background-color: #f7f7f7;
            left: 0;
            right: 0;
            height: 1.5em;
            margin: 0;
            padding: 0.6em 40px 0.4em 0;
            z-index: 6000000;
            font: 11px Verdana, Arial, sans-serif;
            text-align: left;
            color: #444;
            background-image: -moz-linear-gradient(top, #e4e4e4, #ffffff);
            background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#e4e4e4), to(#ffffff));
            background-image: -o-linear-gradient(top, #e4e4e4, #ffffff);
            background: linear-gradient(top, #e4e4e4, #ffffff);
            bottom: 0;
            border-top: 1px solid #bbb;
            box-shadow: rgba(0, 0, 0, 0.3) 0 0 50px;
        }
        #sarasadebughash {
            float: left;
            background-color: #333;
            margin: -4px 1em 0 1em;
            color: #FFF;
            padding: 0.4em 0.9em;
            -webkit-box-shadow: inset 3px 8px 14px rgba(0, 0, 0, 0.45);
            box-shadow: inset 3px 8px 14px rgba(0, 0, 0, 0.45);
        }
        #sarasadebughash a {
            color: #FFF;
            display: block;
        }
        #sarasadebughash i {
            float: left;
            margin: 0 8px 0 0;
        }
        #sarasadebugbar .debugitem {
            float: left;
            border-right: 1px solid #666;
            padding-right: 10px;
            margin-left: 1em;
        }
        #sarasadebugbar .debugitem:last-child {
            padding-right: 0;
            border-right: 0;
        }
        </style>
        <script type="text/javascript">
        (function(){
            $(document).on('ready', function(event) {
                loaddebugbar('{$sarasa.debugpath}/{$sarasa.mtime}', true);
            });

            var originalf = f;
            f = function(funcion, parameters, notloading) {
                parameters['debughash'] = $('#sarasadebugbar').attr('data-hash');
                originalf(funcion, parameters, notloading);
            }

        })();
        function loaddebugbar(hash, nohighlight) {
            $('#sarasadebugbar').attr('data-hash', hash);
            $('#sarasadebughash span').text(hash);
            $('#sarasadebughash a').attr('href', '/_sarasa/debugger/'+hash);
            $('#debugcontainer').html('<img src="/img/sarasa/loading.gif">');

            if (!nohighlight) $('#sarasadebugbar').effect('highlight', 1000);

            var parameters = Array(1);
            parameters['hash'] = hash;

            f('debugbar', parameters, true);
        }
        </script>

        <div id="sarasadebugbar">
            <div id="sarasadebughash"><a><i class="icon icon-white icon-briefcase"></i> <span></span></a></div>
            <div id="debugcontainer" class="debugitem"><img src="/img/sarasa/loading.gif"></div>
        </div>