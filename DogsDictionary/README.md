## README


## 파일 정보
- /index.php : 메인페이지
- /deatil.php : 상세 페이지 + 댓글 기능
- /search.php : 강아지 목록 총괄 페이지
- /like.php : 사용자의 좋아요 목록 페이지
- /db.php : db 연결 and db 함수 정의
- /login.php : 로그인 form 페이지
- /loginOk.php : 로그인 기능
- /logout.php : 로그아웃 기능
- /register.php : 회원가입 form / 회원가입 기능
- /getList.php : 강아지 목록 디자인 페이지
- /like_toggle.php : 좋아요 추가 / 좋아요 삭제 기능
- /reply_add.php : 댓글 등록
- /reply_delete.php : 댓글 삭제
- /reply_update.php : 댓글 수정
- /includes
    - /head.php : header
    - /tail.php : footer
    - /init.php : 불러오는곳
- /assets
    - /css
        - /common.css : css 통합 파일
        - /auth.css : 로그인/회원가입 페이지 css
        - /detail.css : 상세 페이지 css
        - /search.css : 강아지 목록 페이지 css
    - /images : 로고, 강아지들 이미지, 좋아요 버튼 이미지등등

## DB

### user
```
    create table user(
        id int primary key AUTO_INCREMENT,
        name varchar(20) not null,
        password varchar(255) not null,
        username varchar(25) not null
    );
```

### like_check

```
    create table user_likes_dogs(
        user_id int AUTO_INCREMENT,
        dog_id int,
        foreign key(user_id, dog_id)
    );
```


### dog_data

``` 
    create table dogs(
        id int primary key,
        name varchar(20),
        live varchar(20),
        pern varchar(20),
        photo_url varchar(255),
        views int
    );
```

### replys

```
    create table replys(
        reply_id int primary key auto_increment,
        user_id int not null,
        dog_id int not null,
        content varchar(255) not null
    )