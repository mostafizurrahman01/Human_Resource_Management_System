//1. register user
CREATE OR REPLACE PROCEDURE register_user(
    p_name IN users.name%TYPE,
    p_username IN users.username%TYPE,
    p_email IN users.email%TYPE,
    p_password IN users.pass%TYPE
)
IS
BEGIN
    INSERT INTO users (name, username, email, pass, user_id)
    VALUES (p_name, p_username, p_email, p_password, users_seq.NEXTVAL);
    COMMIT;
END;
/


//2. user adding

CREATE OR REPLACE PROCEDURE add_user(
    p_name IN users.name%TYPE,
    p_username IN users.username%TYPE,
    p_email IN users.email%TYPE,
    p_password IN users.pass%TYPE,
    p_user_id OUT users.user_id%TYPE
)
IS
BEGIN
    INSERT INTO users (name, username, email, pass, user_id)
    VALUES (p_name, p_username, p_email, p_password, users_seq.NEXTVAL)
    RETURNING user_id INTO p_user_id;
    COMMIT;
END;
/

//3. Get user retrieves the user's information based on the provided user ID:

    CREATE OR REPLACE PROCEDURE get_user(
    p_user_id IN users.user_id%TYPE,
    p_name OUT users.name%TYPE,
    p_username OUT users.username%TYPE,
    p_password OUT users.pass%TYPE,
    p_email OUT users.email%TYPE
)
IS
BEGIN
    SELECT name, username, pass, email
    INTO p_name, p_username, p_password, p_email
    FROM users
    WHERE user_id = p_user_id;
END;
/


//4. Update Users:

CREATE OR REPLACE PROCEDURE update_user(
    p_user_id IN users.user_id%TYPE,
    p_name IN users.name%TYPE,
    p_username IN users.username%TYPE,
    p_password IN users.pass%TYPE,
    p_email IN users.email%TYPE
)
IS
BEGIN
    UPDATE users
    SET name = p_name,
        username = p_username,
        pass = p_password,
        email = p_email
    WHERE user_id = p_user_id;
    
    COMMIT;
END;
/

//5. Delete Users:

CREATE OR REPLACE PROCEDURE delete_user (
    p_user_id IN users.user_id%TYPE
)
IS
BEGIN
    DELETE FROM users
    WHERE user_id = p_user_id;
    COMMIT;
END;


//Functions:

//1. login validation FUNCTION

CREATE OR REPLACE FUNCTION validate_login(
    p_username IN users.username%TYPE,
    p_password IN users.pass%TYPE
)
RETURN NUMBER
IS
    l_count NUMBER := 0;
BEGIN
    SELECT COUNT(*) INTO l_count
    FROM users
    WHERE username = p_username AND pass = p_password;

    RETURN l_count;
END;
/

//2. Search Function

CREATE OR REPLACE FUNCTION user_search(a_name VARCHAR)
    RETURN SYS_REFCURSOR AS
    my_cursor SYS_REFCURSOR;
BEGIN
    OPEN my_cursor FOR
        SELECT name, username, email, pass, user_id
        FROM users
        WHERE username LIKE '%' || a_name || '%';
    RETURN my_cursor;
END;
/

3. Advanced Search Function

CREATE OR REPLACE FUNCTION advanced_user_search(a_name VARCHAR, a_email VARCHAR)
    RETURN SYS_REFCURSOR AS
    my_cursor SYS_REFCURSOR;
BEGIN
    OPEN my_cursor FOR
        SELECT name, username, email, pass, user_id
        FROM users
        WHERE username LIKE '%' || a_name || '%' AND email LIKE '%' || a_email || '%';

    RETURN my_cursor;
END;
/
