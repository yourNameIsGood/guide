filetype plugin on
set omnifunc=syntaxcomplete#Complete
set smartindent
set tabstop=4
set shiftwidth=4
set expandtab
inoremap {<CR> {<CR>}<Esc>ko
set encoding=UTF-8 
set nu
set hlsearch
set ic

map <F2> : Flisttoggle <CR>
map <c-n> [{
map <c-m> ]}

map <C-j> <C-W>j
map <C-k> <C-W>k
map <C-h> <C-W>h
map <C-l> <C-W>l

let @m = "oecho '<PRE>';var_dump($s);die;Ifss"
let @l = "ofile_put_contents(dirname(__FILE__).'/'.$file,$content,FILE_APPEND|LOCK_EX);"

let @d = ":r !date +%Y/%m/%d\ %H:%M"

let @p = ":r !data€kbeo"
let @p = ":r !dateI### o€kb"
