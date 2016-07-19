filetype plugin on
set omnifunc=syntaxcomplete#Complete
set smartindent
set tabstop=4
set shiftwidth=4
set expandtab
inoremap {<CR> {<CR>}<Esc>ko
set encoding=UTF-8 
set nu

map <F2> : Flisttoggle <CR>
map <c-k> [{
map <c-l> ]}

let @m = "oecho '<PRE>';var_dump($s);die;Ifss"
let @l = "ofile_put_contents(dirname(__FILE__).'/'.$file,$content,FILE_APPEND|LOCK_EX);"
