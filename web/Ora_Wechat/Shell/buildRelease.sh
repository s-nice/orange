#/bin/bash
####### 打包自动化工具 #######

# 提示用户输入要打包的版本号。 可以是全包版本号如2.0.1， 也可以是补丁包版本号2.0.1.1
echo "请输入版本号："
read version
#echo "$version"
# 获取补丁的版本号
patchNumber=`echo "$version" | awk -F "." '{print $4}'`
# 获取小版本号
versionNumber=`echo "$version" | awk -F "." '{print $3}'`
# 获取大版本号
bigVersion=`echo "$version" | awk -F "." '{print $1"."$2"."$3}'`

echo "拉取文件中......"
# 如果安装了 expect, 使用 expect 来执行拉取操作，免去输入git密码
if [ -f /usr/bin/expect ] ; then
    /usr/bin/expect <<EOF
    spawn /usr/bin/git pull
    expect ":"
    send "2bz2cu@0radt!123\r"
    expect eof
    exit
EOF
# 使用shell拉取， 需要输入密码
else
    git pull
fi

# 如果补丁版本号为空， 或者是小版本号为0， 需要做全包 如2.1.1或者2.1.0
if [ "$patchNumber" == '' ] || [ "$versionNumber" == '0' ]; then
    echo "Building package V$version ..."
    filename="ImOra.$version.tgz"
    # 全包的大宝命令
    result=`tar zcf $filename Apps Config Public Libs Shell`
else
# 做补丁包
    echo "Building patch V$version ..."
    #  当前版本的第一个补丁包
    if [ "$patchNumber" == '1' ] ; then
        preVersion="$bigVersion"
    # 非第一个补丁包， 算出上一个补丁包版本号
    else
        declare -i prePatchNumber=$patchNumber-1
        preVersion=`echo $bigVersion"."$prePatchNumber`
    fi
    # 从git log中找到上一版的版本号的提交记录
    command="preCommit=\`git log --oneline | awk -F \" \" '{if (\$3==\"v$preVersion\" && \$2==\"[tag]\" ) {print \$1;}}'\`";
#echo $command
    eval $command ;
    # 获取最新的提交记录
    nowCommit=`git log --oneline -1 | awk -F " " '{print $1;}'`
    filename="Patch_"$patchNumber"_ImOra.$version.tgz"
    # 比较两个版本的差异，进行打包
    git diff --name-only "$nowCommit" "$preCommit" | xargs tar zcf "$filename";
fi

if [ -f $filename ] ; then
    echo "包文件已建立： $filename"
    echo "移动包文件中..."
    # 创建目录用来挂载包文件目录 方便包文件复制移动
    mntdir="mntdir";
    mkdir -p $mntdir;
    mount -t cifs -o user=jiyl,password=123456Aa,iocharset=utf8 \\\\192.168.40.150\\c-sw $mntdir;
    newdir="$mntdir/Web/ProductRelease/ImOra/2.x"
    if [ -d $newdir ] ; then
    	newdir="$newdir/$version"
    	mkdir -p $newdir;
	    newfile="$newdir/$filename" 
	    cp $filename $newfile;
	    if [ -f $newfile ]; then
	        echo "已成功移动包文件到指定位置"
	    else
	        echo "移动包文件失败"
	    fi
	    # 取消挂载点 删除目录
	    umount $mntdir;
	#	rm $mntdir -rf
    else
    	echo "移动包文件失败"
    fi

else
    echo "打包失败！"
fi

exit 0;
