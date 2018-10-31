set ts=4 sts=4 et
set expandtab
set shiftwidth=4
set softtabstop=4

set keywordprg=pman

map <buffer> ns :call PhpInsertUse()<CR>
map <buffer> bns :call PhpExpandClass()<CR>

let &tags = "tags"
" let &tags = join(split(glob("php.*.tags"), "\n"), ",")

map <leader>sp :execute ":! cowsay ".@%." && php -l ".@%." && phpspec run ".@%." -fpretty -vv"<CR>

let g:ale_linters = { 'php': ['php', 'phpstan', 'lsp'] }
let g:ale_php_phpstan_level = 7
let g:ale_lint_on_enter=0
let g:ale_sign_warning = '!>'
let g:ale_sign_info = '!>'
let g:ale_sign_style_warning = '!>'
