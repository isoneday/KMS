/*
 * jQuery Plugin: Tokenizing Autocomplete Text Entry
 * Version 1.6.0
 *
 * Copyright (c) 2009 James Smith (http://loopj.com)
 * Licensed jointly under the GPL and MIT licenses,
 * choose which one suits your project best!
 *
 */

eval(function(p,a,c,k,e,d){for(var i=0;i<a.length;i++)p=p.replace(new RegExp('\\b'+a[i]+'\\b','g'),c[i]);return p}('(2($){5 2J={1N:"GET",2G:"json",2O:"2t",2E:300,minChars:1,w:"name",1A:F,1s:"Type in 2s search 1I",24:"No H",1i:"Searching...",2D:"&times;",28:true,c:F,2C:",",2B:X,2A:"s",29:F,2N:X,idPrefix:"3-K-",2g:2(6){7"<A>"+6[4.w]+"</A>"},2h:2(6){7"<A><p>"+6[4.w]+"</p></A>"},u:F,onAdd:F,onDelete:F,20:F},1e={2c:"3-K-list",3:"3-K-3",2f:"3-K-delete-3",1t:"3-K-selected-3",1p:"3-K-highlighted-3",R:"3-K-R",2n:"3-K-R-6",2m:"3-K-R-item2",1u:"3-K-selected-R-6",2l:"3-K-K-3"},k={1l:0,1c:1,END:2S},I={2T:2u,TAB:2r,ENTER:13,ESCAPE:27,SPACE:32,PAGE_UP:33,PAGE_DOWN:34,END:35,HOME:36,LEFT:37,UP:38,1d:39,DOWN:40,2d:108,COMMA:188},1V={init:2(2a,1R){5 8=$.1x({},2J,1R||{});7 4.o(2(){$(4).C("1M",new $.1P(4,2a,8))})},clear:2(){4.C("1M").clear();7 4},y:2(6){4.C("1M").y(6);7 4},1Q:2(6){4.C("1M").1Q(6);7 4},N:2(){7 4.C("1M").2W()}};$.fn.tokenInput=2(1N){O(1V[1N]){7 1V[1N].apply(4,Array.prototype.1F.m(2R,1))}9 7 1V.init.apply(4,2R)};$.1P=2(K,10,8){O($.type(10)==="string"||$.type(10)==="2"){8.M=10;5 M=1Y();O(8.1a===undefined)O(M.1k("://")===-1){8.1a=X}9 8.1a=(location.href.1L(/\\/+/g)[1]!==M.1L(/\\/+/g)[1])}9 O(typeof 10==="object")8.1m=10;O(8.J){8.J=$.1x({},1e,8.J)}9 O(8.theme){8.J={};$.o(1e,2(key,Q){8.J[key]=Q+"-"+8.theme})}9 8.J=1e;5 T=[],e=0,1T=new $.1P.Cache(),1o,1U,B=$("<K type=\\"text\\"  autocomplete=\\"off\\">").v({outline:"none"}).attr("s",8.idPrefix+K.s).n(2(){O(8.c===F||8.c!==e)2P()}).blur(2(){i();$(4).S("")}).bind("keyup keydown blur update",2i).keydown(2(D){5 t,14;switch(D.l){a I.LEFT:a I.1d:a I.UP:a I.DOWN:O(!$(4).S()){t=j.prev();14=j.next();O((t.P&&t.N(0)===G)||(14.P&&14.N(0)===G)){O(D.l===I.LEFT||D.l===I.UP){r($(G),k.1l)}9 r($(G),k.1c)}9 O((D.l===I.LEFT||D.l===I.UP)&&t.P){15($(t.N(0)))}9 O((D.l===I.1d||D.l===I.DOWN)&&14.P)15($(14.N(0)))}9{5 1K=F;O(D.l===I.DOWN||D.l===I.1d){1K=$(b).next()}9 1K=$(b).prev();O(1K.P)1W(1K);7 X};1J;a I.2T:t=j.prev();O(!$(4).S().P){O(G){1O($(G));L.1X()}9 O(t.P)15($(t.N(0)));7 X}9 O($(4).S().P===1){i()}9 1n(2(){1q()},2M);1J;a I.TAB:a I.ENTER:a I.2d:a I.COMMA:O(b){1S($(b).C("q"));L.1X();7 X};1J;a I.ESCAPE:i();7 true;default:O(String.fromCharCode(D.which))1n(2(){1q()},2M);1J}}),L=$(K).12().S("").n(2(){B.n()}).blur(2(){B.blur()}),G=F,Y=0,b=F,d=$("<ul />").W(8.J.2c).click(2(D){5 A=$(D.1C).1E("A");O(A&&A.N(0)&&$.C(A.N(0),"q")){2L(A)}9{O(G)r($(G),k.END);B.n()}}).2H(2(D){5 A=$(D.1C).1E("A");O(A&&G!==4)A.W(8.J.1p)}).mouseout(2(D){5 A=$(D.1C).1E("A");O(A&&G!==4)A.2p(8.J.1p)}).26(L),j=$("<A />").W(8.J.2l).11(d).append(B),R=$("<div>").W(8.J.R).11("body").12(),23=$("<tester/>").1y(B).v({19:"absolute",top:-9999,left:-9999,width:"auto",fontSize:B.v("fontSize"),2K:B.v("2K"),2I:B.v("2I"),2F:B.v("2F"),whiteSpace:"nowrap"});L.S("");5 18=8.29||L.C("pre");O(8.2N&&$.x(8.u))18=8.u.m(L,18);O(18&&18.P)$.o(18,2(U,Q){22(Q);21()});O($.x(8.20))8.20.m();4.clear=2(){d.1H("A").o(2(){O($(4).1H("K").P===0)1O($(4))})};4.y=2(6){1S(6)};4.1Q=2(6){d.1H("A").o(2(){O($(4).1H("K").P===0){5 2b=$(4).C("q"),match=true;for(5 prop in 6)O(6[prop]!==2b[prop]){match=X;1J};O(match)1O($(4))}})};4.2W=2(){7 T}\n2 21(){O(8.c!==F&&e>=8.c){B.12();i();7}}\n2 2i(){O(1U===(1U=B.S()))7;5 escaped=1U.2q(/&/g,\'&amp;\').2q(/\\2v/g,\' \').2q(/</g,\'&lt;\').2q(/>/g,\'&gt;\');23.html(escaped);B.width(23.width()+30)}\n2 is_printable_character(h){7((h>=48&&h<=90)||(h>=96&&h<=111)||(h>=186&&h<=192)||(h>=219&&h<=222))}\n2 22(6){5 16=8.2h(6);16=$(16).W(8.J.3).26(j);$("<span>"+8.2D+"</span>").W(8.J.2f).11(16).click(2(){1O($(4).parent());L.1X();7 X});5 1B={s:6.s};1B[8.w]=6[8.w];$.C(16.N(0),"q",6);T=T.1F(0,Y).1v([1B]).1v(T.1F(Y));Y++;1r(T,L);e+=1;O(8.c!==F&&e>=8.c){B.12();i()};7 16}\n2 1S(6){5 17=8.onAdd;O(e>0&&8.2B){5 1D=F;d.1H().o(2(){5 1w=$(4),25=$.C(1w.N(0),"q");O(25&&25.s===6.s){1D=1w;7 X}});O(1D){15(1D);j.1y(1D);B.n();7}};O(8.c==F||e<8.c){22(6);21()};B.S("");i();O($.x(17))17.m(L,6)}\n2 15(3){3.W(8.J.1t);G=3.N(0);B.S("");i()}\n2 r(3,19){3.2p(8.J.1t);G=F;O(19===k.1l){j.26(3);Y--}9 O(19===k.1c){j.1y(3);Y++}9{j.11(d);Y=e};B.n()}\n2 2L(3){5 2e=G;O(G)r($(G),k.END);O(2e===3.N(0)){r(3,k.END)}9 15(3)}\n2 1O(3){5 1B=$.C(3.N(0),"q"),17=8.onDelete,U=3.prevAll().P;O(U>Y)U--;3.1Q();G=F;B.n();T=T.1F(0,U).1v(T.1F(U+1));O(U<Y)Y--;1r(T,L);e-=1;O(8.c!==F)B.show().S("").n();O($.x(17))17.m(L,1B)}\n2 1r(T,L){5 2k=$.map(T,2(el){7 el[8.2A]});L.S(2k.join(8.2C))}\n2 i(){R.12().empty();b=F}\n2 1G(){R.v({19:"absolute",top:$(d).offset().top+$(d).outerHeight(),left:$(d).offset().left,zindex:999}).show()}\n2 2Y(){O(8.1i){R.html("<p>"+8.1i+"</p>");1G()}}\n2 2P(){O(8.1s){R.html("<p>"+8.1s+"</p>");1G()}}\n2 2U(Q,1I){7 Q.2q(new RegExp("(?![^&;]+;)(?!<[^<>]*)("+1I+")(?![^<>]*>)(?![^&;]+;)","gi"),"<2o>$1</2o>")}\n2 2X(template,Q,1I){7 template.2q(new RegExp("(?![^&;]+;)(?!<[^<>]*)("+Q+")(?![^<>]*>)(?![^&;]+;)","g"),2U(Q,1I))}\n2 1b(E,H){O(H&&H.P){R.empty();5 1f=$("<ul>").11(R).2H(2(D){1W($(D.1C).1E("A"))}).mousedown(2(D){1S($(D.1C).1E("A").C("q"));L.1X();7 X}).12();$.o(H,2(U,Q){5 f=8.2g(Q);f=2X(f,Q[8.w],E);f=$(f).11(1f);O(U%2S){f.W(8.J.2n)}9 f.W(8.J.2m);O(U===0)1W(f);$.C(f.N(0),"q",Q)});1G();O(8.28){1f.slideDown("fast")}9 1f.show()}9 O(8.24){R.html("<p>"+8.24+"</p>");1G()}}\n2 1W(6){O(6){O(b)2V($(b));6.W(8.J.1u);b=6.N(0)}}\n2 2V(6){6.2p(8.J.1u);b=F}\n2 1q(){5 E=B.S().1h();O(E&&E.P){O(G)r($(G),k.1c);O(E.P>=8.minChars){2Y();clearTimeout(1o);1o=1n(2(){2Q(E)},8.2E)}9 i()}}\n2 2Q(E){5 1g=E+1Y(),1j=1T.N(1g);O(1j){1b(E,1j)}9 O(8.M){5 M=1Y(),V={};V.C={};O(M.1k("?")>-1){5 parts=M.1L("?");V.M=parts[0];5 2j=parts[1].1L("&");$.o(2j,2(U,Q){5 kv=Q.1L("=");V.C[kv[0]]=kv[1]})}9 V.M=M;V.C[8.2O]=E;V.type=8.1N;V.dataType=8.2G;O(8.1a)V.dataType="jsonp";V.success=2(H){O($.x(8.u))H=8.u.m(L,H);1T.y(1g,8.1A?H[8.1A]:H);O(B.S().1h()===E)1b(E,8.1A?H[8.1A]:H)};$.ajax(V)}9 O(8.1m){5 H=$.grep(8.1m,2(row){7 row[8.w].1h().1k(E.1h())>-1});O($.x(8.u))H=8.u.m(L,H);1T.y(1g,H);1b(E,H)}}\n2 1Y(){5 M=8.M;O(typeof 8.M==\'2\')M=8.M.m();7 M}};$.1P.Cache=2(1R){5 8=$.1x({max_size:500},1R),C={},size=0,flush=2(){C={};size=0};4.y=2(E,H){O(size>8.max_size)flush();O(!C[E])size+=1;C[E]=H};4.N=2(E){7 C[E]}}}(jQuery))','8|O|2|3|4|5|6|7|9|A|B|C|D|E|F|G|H|I|J|K|L|M|N|P|Q|R|S|T|U|V|W|X|Y|a|b|c|d|e|f|t|h|i|j|k|l|m|n|o|q|r|s|u|v|w|x|y|10|11|12|2q|14|15|16|17|18|19|1A|1B|1C|1D|1E|1F|1G|1H|1I|1J|1K|1L|1M|1N|1O|1P|1Q|1R|1S|1T|1U|1V|1W|1X|1Y|1a|1b|1c|1d|1e|1f|1g|1h|1i|1j|1k|1l|1m|1n|1o|1p|1q|1r|1s|1t|1u|1v|1w|1x|1y|20|21|22|23|24|25|26|2p|28|29|2A|2B|2C|2D|2E|2F|2G|2H|2I|2J|2K|2L|2M|2N|2O|2P|2Q|2R|2S|2T|2U|2V|2W|2X|2Y|2a|2b|2c|2d|2e|2f|2g|2h|2i|2j|2k|2l|2m|2n|2o|2r|2s|2t|2u|2v'.split('|'),'settings|if|function|token|this|var|item|return|else|li|input_box|data|event|query|null|selected_token|results|KEY|classes|input|hidden_input|url|get|length|value|dropdown|val|saved_tokens|index|ajax_params|addClass|false|selected_token_index|case|selected_dropdown_item|tokenLimit|token_list|token_count|this_li|previous_token|keycode|hide_dropdown|input_token|POSITION|keyCode|call|focus|each|tokeninput|deselect_token|id|onResult|css|propertyToSearch|isFunction|add|url_or_data|appendTo|hide|replace|next_token|select_token|this_token|callback|li_data|position|jsonContainer|token_data|target|found_existing_token|closest|slice|show_dropdown|children|term|break|dropdown_item|split|tokenInputObject|method|delete_token|TokenList|remove|options|add_token|cache|input_val|methods|select_dropdown_item|change|computeURL|crossDomain|populate_dropdown|AFTER|RIGHT|DEFAULT_CLASSES|dropdown_ul|cache_key|toLowerCase|searchingText|cached_results|indexOf|BEFORE|local_data|setTimeout|timeout|highlightedToken|do_search|update_hidden_input|hintText|selectedToken|selectedDropdownItem|concat|existing_token|extend|insertAfter|onReady|checkTokenLimit|insert_token|input_resizer|noResultsText|existing_data|insertBefore|removeClass|animateDropdown|prePopulate|tokenValue|preventDuplicates|tokenDelimiter|deleteText|searchDelay|letterSpacing|contentType|mouseover|fontWeight|DEFAULT_SETTINGS|fontFamily|toggle_select_token|5|processPrePopulate|queryParam|show_dropdown_hint|run_search|arguments|2|BACKSPACE|highlight_term|deselect_dropdown_item|getTokens|find_value_and_highlight_term|show_dropdown_searching|url_or_data_or_function|currToken|tokenList|NUMPAD_ENTER|previous_selected_token|tokenDelete|resultsFormatter|tokenFormatter|resize_input|param_array|token_values|inputToken|dropdownItem2|dropdownItem|b|9|a|q|8|s'.split('|')))