set ts=4 sts=4 et
set expandtab
set shiftwidth=4
set softtabstop=4

map <buffer> ns :call PhpInsertUse()<CR>
map <buffer> bns :call PhpExpandClass()<CR>

let &tags = join(split(glob("php.*.tags"), "\n"), ",")

map <leader>sp :execute ":! ponysay ".@%." && phpspec run ".@%." -fpretty -vv"<CR>
