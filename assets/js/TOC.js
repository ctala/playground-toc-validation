/**
 *
 * @param session_id
 * @param document_side
 * @param div
 * @param document_type
 */
function tocCapture(session_id, document_side, div, document_type = "CHL2") {
    TOCautocapture(div, {
            locale: "es",
            session_id: session_id,
            document_type: document_type,
            document_side: document_side,
            callback: function (captured_token, image) {
                alert(captured_token);
                $("#token-form").val(captured_token);
            },
            failure: function (error) {
                alert(error);
            }
        }
    );
}

function tocLiveness(session_id) {
    TOCliveness('liveness', {
            locale: "es",
            session_id: session_id,
            callback: function (token) {
                alert(token);
                $("#token-form").val(token);
            },
            failure: function (error) {
                alert(error);
            }
        }
    );
}