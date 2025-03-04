import{_ as r,M as o,p as d,q as i,R as a,t as e,N as s,U as l,a1 as c}from"./framework-efe98465.js";const h={},u=a("h1",{id:"task-scheduling",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#task-scheduling","aria-hidden":"true"},"#"),e(" Task Scheduling")],-1),_={href:"https://laravel.com/docs/7.x/scheduling",target:"_blank",rel:"noopener noreferrer"},p=a("a",{href:"./console"},"Console Application",-1),k=a("h2",{id:"define-tasks",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#define-tasks","aria-hidden":"true"},"#"),e(" Define Tasks")],-1),f=a("h2",{id:"run-scheduled-tasks",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#run-scheduled-tasks","aria-hidden":"true"},"#"),e(" Run Scheduled Tasks")],-1),m=a("code",null,"schedule:run",-1),g={href:"https://en.wikipedia.org/wiki/Cron",target:"_blank",rel:"noopener noreferrer"},b={href:"https://laravel.com/docs/7.x/scheduling",target:"_blank",rel:"noopener noreferrer"},v=c(`<div class="language-text line-numbers-mode" data-ext="text"><pre class="language-text"><code>* * * * * cd /your-project-path &amp;&amp; php cli.php schedule:run &gt;&gt; /dev/null 2&gt;&amp;1
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="run-scheduled-tasks-in-windows" tabindex="-1"><a class="header-anchor" href="#run-scheduled-tasks-in-windows" aria-hidden="true">#</a> Run Scheduled Tasks in Windows</h3>`,2),w={href:"https://en.wikipedia.org/wiki/Windows_Task_Scheduler",target:"_blank",rel:"noopener noreferrer"},x={href:"https://quantizd.com/how-to-use-laravel-task-scheduler-on-windows-10/",target:"_blank",rel:"noopener noreferrer"},L=a("h2",{id:"limitations",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#limitations","aria-hidden":"true"},"#"),e(" Limitations")],-1),T={href:"https://laravel.com/docs/7.x/scheduling#scheduling-queued-jobs",target:"_blank",rel:"noopener noreferrer"},S={href:"https://packagist.org/packages/illuminate/queue",target:"_blank",rel:"noopener noreferrer"};function y(C,R){const t=o("ExternalLinkIcon"),n=o("RouterLink");return d(),i("div",null,[u,a("p",null,[e("Laravel's "),a("a",_,[e("Tasks Scheduling"),s(t)]),e(" is also offered by the "),p,e(".")]),k,a("p",null,[e("The "),s(n,{to:"/archive/v4x/console/schedules.html"},{default:l(()=>[e("Console Package")]),_:1}),e(" contains examples of how to define scheduled tasks and how to register them.")]),f,a("p",null,[e("Just like Laravel, you need to add the "),m,e(" command to your "),a("a",g,[e("Cron"),s(t)]),e(". Review Laravel's "),a("a",b,[e("documentation"),s(t)]),e(" for more information about how to run scheduled tasks")]),v,a("p",null,[e("It is possible to use "),a("a",w,[e("Windows Tasks Scheduler"),s(t)]),e(", in order to utilise Laravel's scheduled tasks. Waleed Ahmed wrote a nice article about "),a("a",x,[e("how to use Task Scheduler on Windows 10"),s(t)]),e(".")]),L,a("p",null,[a("a",T,[e("Scheduled Queued Jobs"),s(t)]),e(" are not support by default. You have to add Laravel's "),a("a",S,[e("Queue package"),s(t)]),e(" by on your own, in order to gain access to this feature.")])])}const W=r(h,[["render",y],["__file","tasks.html.vue"]]);export{W as default};
