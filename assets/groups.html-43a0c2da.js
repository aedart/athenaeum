import{_ as s,p as n,q as a,a1 as e}from"./framework-efe98465.js";const t={},p=e(`<h1 id="user-groups" tabindex="-1"><a class="header-anchor" href="#user-groups" aria-hidden="true">#</a> User Groups</h1><p>Redmine allows assigning issues to either a user or a group of users. The distinction can be very difficult to see in Redmine&#39;s API, if at all possible. This package does attempt to automatically resolve an assigned user or group, for issues - when requested. It does, however, come at the cost of addition requests.</p><p>In this section, you will find a brief guide on working with user groups.</p><h2 id="creating-new-group" tabindex="-1"><a class="header-anchor" href="#creating-new-group" aria-hidden="true">#</a> Creating new Group</h2><p>When creating a new group, you can immediately specify the users that must be part of the group, by setting the <code>user_ids</code> property.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Redmine<span class="token punctuation">\\</span>Group</span><span class="token punctuation">;</span>

<span class="token variable">$group</span> <span class="token operator">=</span> <span class="token class-name static-context">Group</span><span class="token operator">::</span><span class="token function">create</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Senior Developers&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;user_ids&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span> <span class="token number">1234</span><span class="token punctuation">,</span> <span class="token number">665</span><span class="token punctuation">,</span> <span class="token number">22</span><span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="adding-users-to-existing-group" tabindex="-1"><a class="header-anchor" href="#adding-users-to-existing-group" aria-hidden="true">#</a> Adding users to existing group</h2><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Redmine<span class="token punctuation">\\</span>user</span><span class="token punctuation">;</span>

<span class="token variable">$user</span>  <span class="token operator">=</span> <span class="token class-name static-context">User</span><span class="token operator">::</span><span class="token function">findOrFail</span><span class="token punctuation">(</span><span class="token number">32</span><span class="token punctuation">)</span><span class="token punctuation">;</span> 

<span class="token variable">$group</span> <span class="token operator">=</span> <span class="token class-name static-context">Group</span><span class="token operator">::</span><span class="token function">findOrFail</span><span class="token punctuation">(</span><span class="token number">40</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$group</span><span class="token operator">-&gt;</span><span class="token function">adduser</span><span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>The <code>addUser()</code> accepts multiple types of values, such as a user id, instance or reference (<em>a nested dto object</em>).</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// Add user with id 40 to group...</span>
<span class="token variable">$group</span><span class="token operator">-&gt;</span><span class="token function">adduser</span><span class="token punctuation">(</span><span class="token number">40</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="removing-users-from-group" tabindex="-1"><a class="header-anchor" href="#removing-users-from-group" aria-hidden="true">#</a> Removing users from group</h2><p>Likewise, you can use the <code>removeUser()</code> to remove a user from an existing group.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$group</span><span class="token operator">-&gt;</span><span class="token function">removeUser</span><span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// ...Or via user&#39;s id</span>
<span class="token variable">$group</span><span class="token operator">-&gt;</span><span class="token function">removeUser</span><span class="token punctuation">(</span><span class="token number">40</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="issues-assigned-to-group" tabindex="-1"><a class="header-anchor" href="#issues-assigned-to-group" aria-hidden="true">#</a> Issues assigned to group</h2><p>Given that you have obtained a group and would like to know all issues that are assigned to that group, then you can use the <code>assignedIssues()</code> relations method to obtain a paginated list of issues.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$issues</span> <span class="token operator">=</span> <span class="token variable">$group</span>
    <span class="token operator">-&gt;</span><span class="token function">assignedIssues</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">limit</span><span class="token punctuation">(</span><span class="token number">50</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">offset</span><span class="token punctuation">(</span><span class="token number">51</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">fetch</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,16),o=[p];function i(c,r){return n(),a("div",null,o)}const l=s(t,[["render",i],["__file","groups.html.vue"]]);export{l as default};
