import{_ as i,M as o,p as c,q as r,R as e,t as a,N as t,a1 as s}from"./framework-efe98465.js";const l={},d=e("h1",{id:"data-deduplication",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#data-deduplication","aria-hidden":"true"},"#"),a(" Data Deduplication")],-1),p=e("p",null,[a("Imagine that you are building a small application that allows users to upload small text files containing greetings ("),e("em",null,"or other types of files"),a("). Chances are good that multiple users will upload the exact same greeting messages. Thus, your storage will eventually contain duplicates.")],-1),h=e("em",null,"[...] a technique for eliminating duplicate copies of repeating data [...]",-1),u={href:"https://en.wikipedia.org/wiki/Data_deduplication",target:"_blank",rel:"noopener noreferrer"},m=e("em",null,"Wiki",-1),f=s(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$content</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;Hi there&#39;</span><span class="token punctuation">;</span>

<span class="token variable">$filesystem</span><span class="token operator">-&gt;</span><span class="token function">write</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;home/message.txt&#39;</span><span class="token punctuation">,</span> <span class="token variable">$content</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$filesystem</span><span class="token operator">-&gt;</span><span class="token function">write</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;home/other_message.txt&#39;</span><span class="token punctuation">,</span> <span class="token variable">$content</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>In the above example, two files are written to the database. However, the adapter ensures that the content is only stored once.</p><h2 id="content-hashing" tabindex="-1"><a class="header-anchor" href="#content-hashing" aria-hidden="true">#</a> Content Hashing</h2><p>Data deduplication is achieved by hashing a file&#39;s content and checking if that hash already exists. If that is the case, then an internal <code>reference_count</code> is incremented. Content is not inserted if this is the case. However, if the hash does not exist, then content is inserted into the database.</p><p>By default, <code>sha256</code> hashing algorithm is used when hashing contents. You can change this via the <code>setHashAlgorithm()</code>:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$adapter</span><span class="token operator">-&gt;</span><span class="token function">setHashAlgorithm</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;md5&#39;</span><span class="token punctuation">)</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div>`,6),g={class:"custom-container warning"},k=e("p",{class:"custom-container-title"},"Caution",-1),_={href:"https://en.wikipedia.org/wiki/Hash_collision",target:"_blank",rel:"noopener noreferrer"},v=s('<h2 id="when-files-are-deleted" tabindex="-1"><a class="header-anchor" href="#when-files-are-deleted" aria-hidden="true">#</a> When files are deleted</h2><p>The adapter automatically cleans up its file-content records, when a file is requested deleted. In this process, the internal <code>reference_count</code> is decreased when a file is deleted. When the reference counter reaches <code>0</code>, actual content is automatically removed.</p><h2 id="performance-considerations" tabindex="-1"><a class="header-anchor" href="#performance-considerations" aria-hidden="true">#</a> Performance Considerations</h2><p>Due to this applied deduplication technique, this adapter <em>SHOULD NOT</em> be expected to be very fast. It will get the job done. But, if performance is very important for your application, then you <em>SHOULD</em> choose a different flysystem adapter!</p>',4);function b(w,x){const n=o("ExternalLinkIcon");return c(),r("div",null,[d,p,e("p",null,[a('To avoid this kind of situation, the database adapter makes use of data deduplication: "'),h,a('" ('),e("a",u,[m,t(n)]),a(") Consider the following:")]),f,e("div",g,[k,e("p",null,[a("Be careful of what hashing algorithm you choose. Some are fast, but might have a high risk of hash-collision. See "),e("a",_,[a("wiki"),t(n)]),a(" for more information.")])]),v])}const H=i(l,[["render",b],["__file","deduplication.html.vue"]]);export{H as default};
