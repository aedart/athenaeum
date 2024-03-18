import{_ as t,M as i,p,q as l,R as s,t as n,N as a,a1 as c}from"./framework-efe98465.js";const o={},r=s("h1",{id:"mime-types",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#mime-types","aria-hidden":"true"},"#"),n(" MIME-Types")],-1),d={href:"https://en.wikipedia.org/wiki/Media_type",target:"_blank",rel:"noopener noreferrer"},u=s("code",null,"resource",-1),m=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>MimeTypes<span class="token punctuation">\\</span>Detector</span><span class="token punctuation">;</span>

<span class="token variable">$file</span> <span class="token operator">=</span> <span class="token function">fopen</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-picture.jpg&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;rb&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Detect mime-type by only reading xx-bytes from file...</span>
<span class="token variable">$mimeType</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">Detector</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">detect</span><span class="token punctuation">(</span><span class="token variable">$file</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token function">fclose</span><span class="token punctuation">(</span><span class="token variable">$file</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token function">print_r</span><span class="token punctuation">(</span><span class="token variable">$mimeType</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>Output example:</p><div class="language-text line-numbers-mode" data-ext="text"><pre class="language-text"><code>Aedart\\MimeTypes\\MimeType Object
(
    [mime] =&gt; image/jpeg; charset=binary
    [type] =&gt; image/jpeg
    [encoding] =&gt; binary
    [known_extensions] =&gt; Array
        (
            [0] =&gt; jpeg
            [1] =&gt; jpg
            [2] =&gt; jpe
            [3] =&gt; jfif
        )
)
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3),v={href:"https://www.php.net/manual/en/book.fileinfo.php",target:"_blank",rel:"noopener noreferrer"};function k(b,g){const e=i("ExternalLinkIcon");return p(),l("div",null,[r,s("p",null,[n('A "profile" based '),s("a",d,[n("MIME-type"),a(e)]),n(" detector, which uses a string or a "),u,n(" as sample.")]),m,s("p",null,[n("Behind the scene, the default profile driver uses PHP's "),s("a",v,[n("File Info Extension"),a(e)]),n(".")])])}const h=t(o,[["render",k],["__file","index.html.vue"]]);export{h as default};
